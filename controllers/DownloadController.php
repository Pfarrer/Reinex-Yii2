<?php
namespace app\controllers;

use app\components\CrudController;
use app\components\I18nModel;
use app\components\MetaModel;
use app\models\I18nDownload;
use app\models\MetaDownload;
use app\models\MetaImage;
use Yii;
use yii\web\HttpException;
use yii\web\UploadedFile;

class DownloadController extends CrudController {

	public function init() {
		$this->metaClassName = MetaDownload::className();
		$this->i18nClassName = I18nDownload::className();
	}

	public function actionIndex() {
		$metas = MetaDownload::find()
			->with('i18n')
			->orderBy('sort')
			->all();
		
		return $this->render('index', ['metas' => $metas]);
	}

	public function actionView($id) {
		return $this->redirect(['index']);
	}

	protected function afterSave(MetaModel &$meta, I18nModel &$i18n) {
		if (!$meta->image) {
			// Neue Downloads verarbeiten
			if ($_FILES && isset($_FILES['image'])) {
				$img = UploadedFile::getInstanceByName('image');
				if (!$img) throw new HttpException(500, 'Es muss ein Bild ausgewählt werden!');
				if ($img->getHasError()) throw new HttpException(500, 'Bild ist fehlerhaft!');

				$metaImage = MetaImage::create($img);
				$metaImage->fmodel = $meta::className();
				$metaImage->fid = $meta->id;
				$metaImage->save();

				$meta->link('image', $metaImage);
			}
		}
	}

}
