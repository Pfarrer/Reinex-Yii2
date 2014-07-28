<?php
namespace app\models;

use app\components\MetaModel;

class MetaContact extends MetaModel {

	public function rules() {
		return [
			['name', 'required'],
			[['name', 'tel', 'mobile', 'mail', 'skype'], 'filter', 'filter' => 'trim'],
		];
	}

	public function attributeLabels() {
		return [
			'tel' => 'Telefon',
			'mobile' => 'Handy',
		];
	}

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
