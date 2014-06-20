<?php
namespace app\models;

use app\components\MetaModel;

class MetaTag extends MetaModel {

	protected function getI18nClassname() {
		return I18nTag::className();
	}

	public static function tableName() {
		return 'tag_meta';
	}
	
}
