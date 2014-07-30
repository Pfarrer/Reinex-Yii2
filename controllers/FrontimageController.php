<?php
namespace app\controllers;

use Yii;
use yii\web\HttpException;
use yii\web\UploadedFile;

use app\components\CrudController;
use app\components\MetaModel;
use app\components\I18nModel;
use app\models\MetaFrontimage;
use app\models\I18nFrontimage;
use app\models\MetaImage;

class FrontimageController extends CrudController {

	public function init() {
		$this->metaClassName = MetaFrontimage::className();
		$this->i18nClassName = I18nFrontimage::className();
	}

	public function actionIndex() {
		$metas = MetaFrontimage::find()
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
			// Neue Images verarbeiten
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
