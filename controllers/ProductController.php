<?php
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\components\CrudController;
use app\components\MetaModel;
use app\components\I18nModel;
use app\models\MetaProduct;
use app\models\I18nProduct;
use app\models\ProductTag;
use app\models\MetaImage;

class ProductController extends CrudController {

	public function init() {
		$this->metaClassName = MetaProduct::className();
		$this->i18nClassName = I18nProduct::className();
	}

	public function actionIndex() {
		$products = MetaProduct::find()
			->with('i18n', 'children')
			->where('parent_id IS NULL')
			->orderBy('sort')
			->all();
		
		return $this->render('index', ['products' => $products]);
	}
	
	public function actionCreate($parent=NULL) {
		if (!$parent) return parent::actionCreate();
		
		$parentMeta = MetaProduct::findOne($parent);
		if (!$parentMeta) throw new NotFoundHttpException();
		
		$meta = new MetaProduct();
		$meta->parent_id = $parentMeta->id;
		
		$i18n = new $this->i18nClassName();
		$i18n->lang = Yii::$app->language;
		
		return parent::updateOrRender($meta, $i18n);
	}

	protected function afterSave(MetaModel &$meta, I18nModel &$i18n) {
		
		// Tags speichern
		ProductTag::deleteAll('product_id=:pid', [':pid' => $meta->id]);
		$post = Yii::$app->request->post('MetaProduct');
		if (isset($post['tags']) && is_array($post['tags'])) {
			foreach ($post['tags'] as $tag_id) {
				$t = new ProductTag();
				$t->product_id = $meta->id;
				$t->tag_id = $tag_id;
				$t->save();
			}
		}
		
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
		
	}

}
