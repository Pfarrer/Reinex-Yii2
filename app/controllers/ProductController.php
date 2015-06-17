<?php
namespace app\controllers;

use app\components\Url;
use app\models\ProductI18n;
use app\models\ProductMeta;
use app\models\ProductTag;
use app\models\Shortcut;
use app\models\TagMeta;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

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
}