<?php
namespace app\models;

use app\components\MetaModel;

class MetaTag extends MetaModel {

	public function getProducts() {
		return $this->hasMany(MetaProduct::className(), ['id'=>'tag_id'])
			->viaTable('product_tag', ['product_id' => 'id'])
			->orderby('sort');
	}
	
	public function getCount() {
		return $this->hasMany(MetaProduct::className(), ['id'=>'tag_id'])
			->viaTable('product_tag', ['product_id' => 'id'])
			->count();
	}

	protected function getI18nClassname() {
		return I18nTag::className();
	}

	public static function tableName() {
		return 'tag_meta';
	}
	
}
