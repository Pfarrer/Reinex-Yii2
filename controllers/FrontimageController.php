<?php
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
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
	
	protected function afterSave(MetaModel &$meta, I18nModel &$i18n) {
		// Neue Images verarbeiten
		if ($_FILES && isset($_FILES['image'])) {
			$upImages = UploadedFile::getInstancesByName('images');
			foreach ($upImages as $img) {
				if ($img->getHasError()) {
					Yii::$app->session->setFlash('warning', 'Bild-Upload wegen internem Fehler übersprungen.');
					continue;
				}
				$metaImage = MetaImage::create($img);
				$metaImage->fmodel = $meta::className();
				$meta->link('images', $metaImage);
			}
		}
		
		// Shortcut prüfen
		if (!$i18n->shortcut && !empty($i18n->shortcut_active)) {
			$shortcut = new Shortcut();
			$shortcut->fid = $i18n->id;
			$shortcut->fmodel = $i18n::className();
			$shortcut->action = 'product/view';
			$shortcut->shortcut = $i18n->shortcut_active;
			$shortcut->save();
		}

		$media_url = Yii::$app->request->post('media_url');
		if ($media_url && !empty($media_url)) {
			$media = new ProductMedia();
			$media->url = str_replace('watch?v=', 'embed/', $media_url);
			$media->name = $media->embed->title;
			$meta->link('medias', $media);

			// Download image
			$imgraw = file_get_contents($media->embed->image);
			$imghash = md5($imgraw);
			$imgbasename = pathinfo($media->embed->image, PATHINFO_FILENAME);
			$imgextension = strtolower(pathinfo($media->embed->image, PATHINFO_EXTENSION));
			file_put_contents('img/uploaded/'.$imghash.'.'.$imgextension, $imgraw);

			$img = new MetaImage();
			$img->hash = $imghash;
			$img->filename = $imgbasename;
			$img->extension = $imgextension;
			$img->fid = $media->id;
			$img->fmodel = $media::className();
			$img->save();
		}
	}

}
