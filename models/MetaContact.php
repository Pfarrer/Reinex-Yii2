<?php
namespace app\models;

use app\components\MetaModel;

class MetaContact extends MetaModel {

	public function getImage() {
		return $this->hasOne(MetaImage::className(), ['id' => 'image_id']);
	}
	
	protected function getI18nClassname() {
		return I18nContact::className();
	}
	
	public static function tableName() {
		return 'contact_meta';
	}
	
}
