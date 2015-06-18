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

	public function actionView($id)
	{
		$meta = ProductMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		if (!$meta->i18n) throw new NotFoundHttpException('This content is not available in your current language.');

		return $this->render('view', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}

	public function actionEdit($id=null)
	{
		if ($id === null) {
			$meta = new ProductMeta();
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