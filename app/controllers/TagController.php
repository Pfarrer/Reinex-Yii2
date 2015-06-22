<?php
namespace app\controllers;

use app\components\Url;
use app\models\TagI18n;
use app\models\TagMeta;
use app\models\Shortcut;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class TagController extends Controller
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
		$meta = TagMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		if ($meta->i18n) {
			$i18n = $meta->i18n;
		}
		else {
			$i18n = $meta->i18n_any;
			Yii::$app->session->addFlash('warning', 'Unfortunately, this content is not available in your selected language.
				You see the <img src="'.Url::base().'/images/flags/'.$i18n->lang.'.png"> '.Yii::t('language', $i18n->lang).' version.');
		}

		return $this->render('view', ['meta' => $meta, 'i18n' => $i18n]);
	}

	public function actionEdit($id=null)
	{
		if ($id === null) {
			$meta = new TagMeta();
			$meta->populateRelation('i18n', new TagI18n());
		}
		else {
			$meta = TagMeta::findOne($id);
			if (!$meta) throw new NotFoundHttpException();
			/** @var $meta TagMeta */
			if (!$meta->i18n) $meta->populateRelation('i18n', new TagI18n());
		}

		if (Yii::$app->request->isPost) {
			$meta->load(Yii::$app->request->post());
			$meta->i18n->load(Yii::$app->request->post());
			
			if ($meta->validate() && $meta->i18n->validate()) {
				Yii::$app->db->transaction(function () use ($meta) {
					if (!$meta->save()) {
						throw new HttpException(400, 'meta save failed!');
					}

					// Update ids and lang
					$meta->i18n->id = $meta->id;
					$meta->i18n->lang = Yii::$app->language;
					if (!$meta->i18n->save()) {
						throw new HttpException(400, 'i18n save failed!');
					}
					
					if ($meta->i18n->shortcut_active) {
						$scut = Shortcut::findOne($meta->i18n->shortcut_active);
						if (!$scut) $scut = new Shortcut();
						$scut->shortcut = $meta->i18n->shortcut_active;
						$scut->action = 'tag/view';
						$scut->fid = $meta->id;
						$scut->fmodel = $meta->className();
						
						if (!$scut->save()) {
							throw new HttpException(400, 'Shortcut save failed!');
						}
					}
				});

				return $this->redirect(Url::toTag($meta));
			}
		}

		return $this->render('form', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}
}