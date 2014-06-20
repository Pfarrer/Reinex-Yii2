<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MetaProduct;

class SiteController extends Controller {

	public function actionIndex() {
		// Produkte mit dieser Sprache finden
		$products = MetaProduct::find()
			->joinWith('i18n')
			->where('parent IS NULL')
			->orderBy('sort')
			->all();
		
		return $this->render('index', [
			'products' => $products,
		]);
	}

	public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
	}

}
