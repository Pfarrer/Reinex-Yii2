<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
	
	public function actionView($id) {
		$meta = MetaProduct::findOne(['id'=>$id]);
		return $this->render('view', ['meta'=>$meta]);
	}
	
	public function actionCreate() {
		$meta = new MetaProduct();
		
		$i18n = new I18nProduct();
		$i18n->lang = Yii::$app->language;
		
		return $this->updateOrRender($meta, $i18n);
	}
	
	public function actionEdit($id) {
		$meta = MetaProduct::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		
		$i18n = $meta->i18n;
		if (!$i18n) {
			$i18n = new I18nProduct();
			$i18n->lang = Yii::$app->language;	
		}
		
		return $this->updateOrRender($meta, $i18n);
	}
	
	private function updateOrRender(MetaProduct $meta, I18nProduct $i18n) {
		// Set new POST values if there are some
		$loaded = $meta->load(Yii::$app->request->post());
		$loaded = $i18n->load(Yii::$app->request->post()) || $loaded;
		
		if (!$loaded) {
			// No values changed -> render form
			return $this->render('form', ['meta'=>$meta, 'i18n'=>$i18n]);
		}
		
		// Something changed -> validate
		$valid = $meta->validate();
		$valid = $i18n->validate() && $valid;
		
		if (!$valid) {
			// Errors in the data -> render form
			return $this->render('form', ['meta'=>$meta, 'i18n'=>$i18n]);
		}
		
		// All right -> start transaction and save data
		$transaction = MetaProduct::getDb()->beginTransaction();
		
		if ($meta->save()) {
			$i18n->id = $meta->id;
			if ($i18n->save()) {
				$transaction->commit();
				return $this->redirect(['view', 'id'=>$meta->id]);
			}
			else {
				return $this->render('form', ['meta'=>$meta, 'i18n'=>$i18n]);
			}
		} else {
			$transaction->rollback();
		}
		
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