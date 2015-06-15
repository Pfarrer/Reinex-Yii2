<?php namespace app\controllers;

use app\forms\LoginForm;
use yii\web\Controller;
use Yii;

class SiteController extends Controller
{
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex()
	{
		$this->layout = 'html';

		$lang = Yii::$app->language;
		$company_profile = file_get_contents("../app/static/company_profile.$lang.textile");
		
		// Contacts mit dieser Sprache finden
		$contacts = \app\models\MetaContact::find()
			->with('i18n') // Kein joinWith
			->orderBy('sort')
			->all();

		return $this->render('index', [
			'company_profile' => $company_profile,
			'contacts' => $contacts,
		]);
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', ['model' => $model]);
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}
}