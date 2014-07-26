<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;

use app\components\CrudController;
use app\components\MetaModel;
use app\components\I18nModel;
use app\models\MetaTag;
use app\models\I18nTag;
use app\models\Shortcut;

class TagController extends CrudController {

	protected function afterSave(MetaModel &$meta, I18nModel &$i18n) {
		// Shortcut prüfen
		if (!$i18n->shortcut && !empty($i18n->shortcut_active)) {
			$shortcut = new Shortcut();
			$shortcut->fid = $i18n->id;
			$shortcut->fmodel = $i18n::className();
			$shortcut->action = 'tag/view';
			$shortcut->shortcut = $i18n->shortcut_active;
			$shortcut->save();
		}
	}

	public function init() {
		$this->metaClassName = MetaTag::className();
		$this->i18nClassName = I18nTag::className();
	}

}
