<?php
/**
 * Created by PhpStorm.
 * User: bpfretzschner
 * Date: 20.06.14
 * Time: 16:08
 */

namespace app\components;

use \Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;

abstract class CrudController extends Controller {

	protected $metaClassName, $i18nClassName;

	public function actionIndex() {
		$metas = call_user_func(array($this->metaClassName, 'find'))
			->with('i18n')->all();

		return $this->render('index', [
			'metas' => $metas,
		]);
	}

	public function actionView($id) {
		// Call static function: $metaClassName::findOne
		$meta = call_user_func([$this->metaClassName, 'findOne'], [$id]);
		if (!$meta) throw new NotFoundHttpException();
		if (!$meta->i18n) throw new NotFoundHttpException('This content is not available in your current language.');

		return $this->render('view', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}

	public function actionCreate() {
		$meta = new $this->metaClassName();

		$i18n = new $this->i18nClassName();
		$i18n->lang = Yii::$app->language;

		return $this->updateOrRender($meta, $i18n);
	}

	public function actionEdit($id) {
		$meta = call_user_func([$this->metaClassName, 'findOne'], [$id]);
		if (!$meta) throw new NotFoundHttpException();

		$i18n = $meta->i18n;
		if (!$i18n) {
			$i18n = new $this->i18nClassName();
			$i18n->lang = Yii::$app->language;
		}

		return $this->updateOrRender($meta, $i18n);
	}

	protected function updateOrRender(MetaModel $meta, I18nModel $i18n) {
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
		$transaction = call_user_func([$this->metaClassName, 'getDb'])->beginTransaction();

		if (!$meta->save()) throw new HttpException(500, 'Save failed: meta');
		if (!$i18n->save()) throw new HttpException(500, 'Save failed: i18n');

		// After-save callback
		$this->afterSave($meta, $i18n);
		
		$transaction->commit();
		return $this->redirect(['view', 'id'=>$meta->id]);

	}
	
	protected function afterSave(MetaModel &$meta, I18nModel &$i18n) {}

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'except' => ['view'],
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
