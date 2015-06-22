<?php
namespace app\controllers;

use app\components\Url;
use app\models\Image;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\models\ProductTag;
use app\models\Shortcut;
use app\models\TagMeta;
use app\widgets\ImageWidget;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProductController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['view'],
					],
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		return $this->redirect(['/#products']);
	}

	public function actionView($id)
	{
		$meta = ProductMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		if ($meta->i18n) {
			$i18n = $meta->i18n;
		}
		else {
			$i18n = $meta->i18n_any;
			Yii::$app->session->addFlash('warning', 'Unfortunately, this content is not available in your selected language.
				You see the <img src="'.Url::base().'/images/flags/'.$i18n->lang.'.png"> '.Yii::t('language', $i18n->lang).' version.');
		}

		if ($meta->frontimage) {
			$this->view->body_background_image_url = ImageWidget::frontimage($meta->frontimage);
		}

		return $this->render('view', ['meta' => $meta, 'i18n' => $i18n]);
	}

	public function actionEdit($id=null, $parent_id=null)
	{
		if ($id === null) {
			$meta = new ProductMeta();
			$meta->parent_id = $parent_id;
			$meta->populateRelation('i18n', new ProductI18n());
		}
		else {
			$meta = ProductMeta::findOne($id);
			if (!$meta) throw new NotFoundHttpException();
			/** @var $meta ProductMeta */
			if (!$meta->i18n) $meta->populateRelation('i18n', new ProductI18n());
		}

		if (Yii::$app->request->isPost) {
			$meta->load(Yii::$app->request->post());
			$meta->i18n->load(Yii::$app->request->post());
			
			if ($meta->validate() && $meta->i18n->validate()) {
				Yii::$app->db->transaction(function () use ($meta) {
					if (!$meta->save()) {
						throw new HttpException(400, 'meta save failed!');
					}

					// Update ids and lang
					$meta->i18n->id = $meta->id;
					$meta->i18n->lang = Yii::$app->language;
					if (!$meta->i18n->save()) {
						throw new HttpException(400, 'i18n save failed!');
					}

					// Handle tags, first delete all associated tags
					{
						ProductTag::deleteAll(['product_id' => $meta->id]);
						$post = Yii::$app->request->post($meta->formName());
						if (isset($post['tags']) && is_array($post['tags'])) {
							$tags = TagMeta::findAll($post['tags']);
							foreach ($tags as $tag) {
								(new ProductTag([
									'product_id' => $meta->id,
									'tag_id' => $tag->id,
								]))->save();
							}
						}
					}

					// Handle shortcut
					if ($meta->i18n->shortcut_active) {
						$scut = Shortcut::findOne($meta->i18n->shortcut_active);
						if (!$scut) $scut = new Shortcut();
						$scut->shortcut = $meta->i18n->shortcut_active;
						$scut->action = 'product/view';
						$scut->fid = $meta->id;
						$scut->fmodel = $meta->className();
						
						if (!$scut->save()) {
							throw new HttpException(400, 'Shortcut save failed!');
						}
					}
				});

				return $this->redirect(Url::toProduct($meta));
			}
		}

		return $this->render('form', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}

	public function actionEdit_images($id)
	{
		$meta = ProductMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		/** @var $meta ProductMeta */

		if (!Yii::$app->request->isPost) throw new HttpException(404);

		$action = Yii::$app->request->post('action');
		$image_sort = Yii::$app->request->post('image_sort', []);
		$image_selected = Yii::$app->request->post('image_selected', []);
		$target_id = Yii::$app->request->post('target_id', null);

		if ($action === 'sort') {
			foreach ($image_sort as $i=>$image_id) {
				Image::updateAll(['sort' => $i], ['id' => $image_id, 'fid' => $meta->id, 'fmodel' => $meta->className()]);
			}
			Yii::$app->session->addFlash('success', 'Image order was succefully saved!');
		}
		else if ($action === 'delete') {
			// Delete the selected images
			foreach ($image_selected as $image_id) {
				$image = Image::findOne(['id' => $image_id, 'fid' => $meta->id, 'fmodel' => $meta->className()]);
				if ($image) $image->delete();
			}
			Yii::$app->session->addFlash('success', 'Image(s) removed!');
		}
		else if ($action === 'move') {
			if (!$target_id) {
				// Show target selection list
				return $this->render('move_target_select', [
					'id' => $id,
					'image_selected' => $image_selected,
					'products' => ProductMeta::find()->andWhere(['parent_id' => null])->orderBy('sort')->all(),
				]);
			}
			else {
				// Move
				Image::updateAll(['fid' => $target_id], ['id' => $image_selected]);
				Yii::$app->session->addFlash('success', 'Image(s) moved!');
			}
		}

		return $this->redirect(Url::toProduct($meta));
	}

	public function actionUpload($id)
	{
		$meta = ProductMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		/** @var $meta ProductMeta */

		if (Yii::$app->request->isPost && isset($_FILES)) {
			$reponse = [];

			foreach (UploadedFile::getInstancesByName('images') as $file) {
				// Check extension
				if (!in_array(strtolower($file->extension), ['jpg', 'jpeg'])) {
					$reponse[] = [
						'name' => $file->name,
						'error' => 'Invalid file type!',
					];
					continue;
				}

				// Check if file exists
				$hash = md5_file($file->tempName);
				$image = Image::findOne(['hash' => $hash]);
				if ($image) {
					// Image exists already on the server
					// Check if it already linked to this product
					$product_image = Image::findOne([
						'hash' => $hash,
						'fid' => $meta->id,
						'fmodel' => $meta->className(),
					]);
					if ($product_image) {
						$reponse[] = [
							'name' => $file->name,
							'error' => 'Image already attached to this product!',
						];
						continue;
					}
					else {
						// Image is new for this product
						$product_image = new Image([
							'hash' => $hash,
							'fid' => $meta->id,
							'fmodel' => $meta->className(),
							'filename' => $file->name,
							'extension' => strtolower($file->extension),
						]);
						$product_image->save();
					}
				}
				else {
					if (!$file->saveAs("uploads/images/$hash.".strtolower($file->extension))) {
						$reponse[] = [
							'name' => $file->name,
							'error' => 'Move failed!',
						];
						continue;
					}

					// Image does not exist yet
					$product_image = new Image([
						'hash' => $hash,
						'fid' => $meta->id,
						'fmodel' => $meta->className(),
						'filename' => $file->name,
						'extension' => strtolower($file->extension),
					]);
					$product_image->save();
				}

				$reponse[] = [
					'name' => $file->name,
					'thumbnail_url' => ImageWidget::thumbnail($product_image),
					'size' => $file->size,
				];
			}

			echo json_encode(['files' => $reponse]);
		}
		else {
			echo 'Error';
		}
	}
}