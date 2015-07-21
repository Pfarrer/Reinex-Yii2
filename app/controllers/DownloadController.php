<?php
namespace app\controllers;

use app\components\Url;
use app\models\Image;
use app\models\DownloadI18n;
use app\models\DownloadMeta;
use app\models\DownloadTag;
use app\models\Shortcut;
use app\models\TagMeta;
use app\widgets\ImageWidget;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DownloadController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['dl'],
					],
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		return $this->redirect(['/#downloads']);
	}

	public function actionDl($id)
	{
		$meta = DownloadMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		/** @var $meta DownloadMeta */

		return $this->redirect(Url::base().'/uploads/files/'.$meta->filename);
	}

	public function actionEdit($id=null)
	{
		if ($id === null) {
			$meta = new DownloadMeta();
			$meta->populateRelation('i18n', new DownloadI18n());
		}
		else {
			$meta = DownloadMeta::findOne($id);
			if (!$meta) throw new NotFoundHttpException();
			/** @var $meta DownloadMeta */
			if (!$meta->i18n) $meta->populateRelation('i18n', new DownloadI18n());
		}


		if (Yii::$app->request->isPost) {
			$meta->load(Yii::$app->request->post());
			$meta->i18n->load(Yii::$app->request->post());

			if ($meta->isNewRecord) {
				$file = UploadedFile::getInstanceByName('file');
				$meta->filename = $file->name;
				$meta->filesize = $file->size;
			}
			else $file = null;
			
			if ($meta->validate() && $meta->i18n->validate()) {
				Yii::$app->db->transaction(function () use ($meta, $file) {
					if (!$meta->save()) {
						throw new HttpException(400, 'meta save failed!');
					}

					// Update ids and lang
					$meta->i18n->id = $meta->id;
					$meta->i18n->lang = Yii::$app->language;
					if (!$meta->i18n->save()) {
						throw new HttpException(400, 'i18n save failed!');
					}

					// Handle shortcut
					if ($meta->i18n->shortcut_active) {
						$scut = Shortcut::findOne($meta->i18n->shortcut_active);
						if (!$scut) $scut = new Shortcut();
						$scut->shortcut = $meta->i18n->shortcut_active;
						$scut->action = 'download/dl';
						$scut->fid = $meta->id;
						$scut->fmodel = $meta->className();
						
						if (!$scut->save()) {
							throw new HttpException(400, 'Shortcut save failed!');
						}
					}

					// Move file
					if ($file) {
						if (!$file->saveAs('uploads/files/'.$meta->filename)) {
							throw new HttpException(400, 'save file failed!');
						}
					}
				});

				return $this->redirect(['/#downloads']);
			}
		}

		return $this->render('form', ['meta' => $meta, 'i18n' => $meta->i18n]);
	}

	public function actionDelete($id)
	{
		$meta = DownloadMeta::findOne($id);
		if (!$meta) throw new NotFoundHttpException();
		/** @var $meta DownloadMeta */

		Yii::$app->db->transaction(function () use ($meta) {
			foreach ($meta->i18ns as $i18n) {
				if (!$i18n->delete()) throw new HttpException(400, 'i18n delete failed!');
			}
			if (!$meta->delete()) throw new HttpException(400, 'meta delete failed!');
		});

		return $this->redirect(['/#downloads']);
	}
}