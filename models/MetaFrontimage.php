<?php
namespace app\models;

use app\components\MetaModel;

class MetaFrontimage extends MetaModel {

	public function rules() {
        return [
            ['image_id', 'integer'],
        ];
    }
    
    public function getImage() {
		return $this->hasOne(MetaImage::className(), ['id' => 'image_id']);
	}

	protected function getI18nClassname() {
		return I18nFrontimage::className();
	}

	public static function tableName() {
		return '{{%frontimage_meta}}';
	}
	
}
