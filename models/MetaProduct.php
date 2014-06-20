<?php
namespace app\models;

use app\components\MetaModel;

class MetaProduct extends MetaModel {

	public function getFrontimage() {
		return $this->hasOne(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}

	public function getImages() {
		return $this->hasMany(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}
	
	protected function getI18nClassname() {
		return I18nProduct::className();
	}
	
	public static function tableName() {
		return 'product_meta';
	}
	
}
