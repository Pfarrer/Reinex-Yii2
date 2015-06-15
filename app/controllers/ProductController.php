<?php
namespace app\controllers;

use app\components\Url;
use app\forms\ProductForm;
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

	public function actionCreate()
	{
		$model = new ProductForm();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(Url::toProduct($model->product_meta));
		} else {
			return $this->render('login', ['model' => $model]);
		}
	}
}