<?php namespace app\controllers;

use app\forms\LoginForm;
use app\models\ContactMeta;
use app\models\DownloadMeta;
use app\models\ProductMeta;
use app\models\TagI18n;
use app\models\TagMeta;
use Yii;
use yii\web\Controller;

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
		$lang = Yii::$app->language;
		$company_profile = file_get_contents("../app/static/company_profile.$lang.textile");

		// Produkte und Kategorien mit dieser Sprache finden
		$products = ProductMeta::find()
			->andWhere(['parent_id' => null])
			->orderby('sort')->all();
		$tags = TagMeta::find()->orderBy('sort')->all();
		$downloads = DownloadMeta::find()->orderby('sort')->all();

		// Contacts mit dieser Sprache finden
		$contacts = ContactMeta::find()->with('i18n')->orderBy('sort')->all();

		return $this->render('index', [
			'products' => $products,
			'tags' => $tags,
			'downloads' => $downloads,
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