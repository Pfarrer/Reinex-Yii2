<?php
namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

use app\components\CrudController;
use app\models\MetaProduct;
use app\models\I18nProduct;
use app\models\MetaImage;

class ProductController extends CrudController {

	public function init() {
		$this->metaClassName = MetaProduct::className();
		$this->i18nClassName = I18nProduct::className();
	}

	public function actionIndex() {
		$products = MetaProduct::find()
			->with('i18n')
			->where('parent IS NULL')
			->orderBy('sort')
			->all();
		
		return $this->render('index', ['products' => $products]);
	}
	
	protected function updateOrRender(MetaProduct $meta, I18nProduct $i18n) {

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
		if ($sorted_image_ids) {
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
				$metaImage->fmodel = $meta::className();
				$meta->link('images', $metaImage);
			}
		}
		
		// Fertig
		$transaction->commit();
		return $this->redirect(['view', 'id'=>$meta->id]);
		
	}

}
