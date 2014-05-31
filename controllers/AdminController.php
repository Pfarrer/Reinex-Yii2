<?php
/**
 * Created by PhpStorm.
 * User: bpfretzschner
 * Date: 28.05.14
 * Time: 17:46
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller {

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {

		if (!\Yii::$app->user->isGuest) {
			return $this->redirect(['admin']);
		}

		$model = new \app\models\LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', ['model' => $model]);
		}

	}

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'logout'],
				'rules' => [
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
		];
	}

	public function actionLogout() {
		Yii::$app->user->logout();
		return $this->goHome();
	}

} 
