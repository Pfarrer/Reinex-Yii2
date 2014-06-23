<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\MetaProduct;
use app\models\MetaTag;

class SiteController extends Controller {

	public function actionIndex() {
		// Produkte mit dieser Sprache finden
		$products = MetaProduct::find()
			->joinWith('i18n')
			->where('parent_id IS NULL')
			->orderBy('sort')
			->all();
			
		// Kategorien mit dieser Sprache finden
		$tags = MetaTag::find()
			->joinWith('i18n')
			->orderBy('tag_i18n.name')
			->all();
		
		return $this->render('index', [
			'products' => $products,
			'tags' => $tags,
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
