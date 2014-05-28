<?php
/**
 * Created by PhpStorm.
 * User: bpfretzschner
 * Date: 28.05.14
 * Time: 17:46
 */

namespace app\controllers;


use yii\web\Controller;

class AdminController extends Controller {

	public function actionLogin() {

		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}

	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	public function actionLogout() {
		Yii::$app->user->logout();
		return $this->goHome();
	}

} 