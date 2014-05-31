<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\MetaProduct;
use app\models\I18nProduct;

class ProductController extends Controller {

	public function actionIndex() {
		$products = MetaProduct::find()
			->with('i18n')
			->orderBy('sort')
			->all();

		return $this->render('index', [
			'products' => $products,
		]);
	}
	
	public function actionEdit($id) {
		$product = Metaproduct::findOne($id);
		
		return $this->render('form', [
			'model' => $product,
		]);
	}
	
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'except' => ['show'],
				'rules' => [
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
		];
	}

}
