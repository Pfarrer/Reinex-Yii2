<?php
namespace app\controllers;

use app\components\Url;
use app\forms\ProductForm;
use app\models\ProductI18n;
use app\models\ProductMeta;
use Yii;
use yii\web\Controller;
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
				$success = Yii::$app->db->transaction(function () use ($meta) {
					if (!$meta->save()) return false;

					// Update ids and lang
					$meta->i18n->id = $meta->id;
					$meta->i18n->lang = Yii::$app->language;
					if (!$meta->i18n->save()) return false;

					return true;
				});

				if ($success) return $this->redirect(Url::toProduct($meta));
				else {
					Yii::$app->session->addFlash('danger', 'Speichern aus unbekanntem Grund fehlgeschlagen!');
				}
			}
		}

		return $this->render('form', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}
}