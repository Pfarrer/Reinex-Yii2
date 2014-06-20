<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;

use app\components\CrudController;
use app\models\MetaTag;
use app\models\I18nTag;

class TagController extends CrudController {

	public function init() {
		$this->metaClassName = MetaTag::className();
		$this->i18nClassName = I18nTag::className();
	}

}
