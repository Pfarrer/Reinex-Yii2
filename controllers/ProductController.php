<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

use app\models\MetaProduct;
use app\models\I18nProduct;
use app\models\MetaImage;

class ProductController extends Controller {

	public function actionIndex() {
		$products = MetaProduct::find()
			->with('i18n')
			->where('parent IS NULL')
			->orderBy('sort')
			->all();

		return $this->render('index.twig', [
			'products' => $products,
		]);
	}
	
	public function actionView($id) {
		$meta = MetaProduct::findOne(['id'=>$id]);
		return $this->render('view.twig', ['meta'=>$meta]);
	}
	
	public function actionCreate() {
		$meta = new MetaProduct();
		
		$i18n = new I18nProduct();
		$i18n->lang = Yii::$app->language;
		
		return $this->updateOrRender($meta, $i18n);
	}
	
	public function actionEdit($id) {
		$meta = MetaProduct::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		
		$i18n = $meta->i18n;
		if (!$i18n) {
			$i18n = new I18nProduct();
			$i18n->lang = Yii::$app->language;	
		}
		
		return $this->updateOrRender($meta, $i18n);
	}
	
	private function updateOrRender(MetaProduct $meta, I18nProduct $i18n) {

		// Set new POST values if there are some
		$loaded = $meta->load(Yii::$app->request->post());
		$loaded = $i18n->load(Yii::$app->request->post()) || $loaded;

		if (!$loaded) {
			// No values changed -> render form
			return $this->render('form', ['meta'=>$meta, 'i18n'=>$i18n]);
		}
		
		// Something changed -> validate
		$valid = $meta->validate();
		$valid = $i18n->validate() && $valid;
		
		if (!$valid) {
			// Errors in the data -> render form
			return $this->render('form', ['meta'=>$meta, 'i18n'=>$i18n]);
		}
		
		// All right -> start transaction and save data
		$transaction = MetaProduct::getDb()->beginTransaction();
		
		// Produkt speichern
		if (!$meta->save()) throw new BadRequestHttpException('meta');
		$i18n->id = $meta->id;
		if (!$i18n->save())  throw new BadRequestHttpException('i18n');
		
		// Alte Images sortieren/entfernen
		$sorted_image_ids = Yii::$app->request->post('image_sort');
		if ($$sorted_image_ids) {
			$old_image_ids = array_map(function ($a) {
				return $a->id;
			}, $meta->images);
			$sort = 1;
			foreach ($sorted_image_ids as $image_id) {
				// Check if that image id is really linked to this product
				if (in_array($image_id, $old_image_ids)) {
					$image = MetaImage::findOne($image_id);
					if ($image->sort !== $sort) {
						// Update sort
						$image->sort = $sort;
						$image->save();
					}

					$sort++;
				}
			}
		}
		
		// Neue Images verarbeiten
		if ($_FILES && isset($_FILES['images'])) {
			$upImages = UploadedFile::getInstancesByName('images');
			foreach ($upImages as $img) {
				if ($img->getHasError()) continue;
				
				$metaImage = MetaImage::create($img);
				$metaImage->fmodel = $model::className();
				$meta->link('images', $metaImage);
			}
		}
		
		// Fertig
		$transaction->commit();
		return $this->redirect(['view', 'id'=>$meta->id]);
		
	}
	
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'except' => ['show'],
				'rules' => [
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
		];
	}

}
