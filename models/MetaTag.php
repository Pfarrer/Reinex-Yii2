<?php
namespace app\models;

use app\components\MetaModel;

class MetaTag extends MetaModel {

	public function getProducts() {
		return $this->hasMany(MetaProduct::className(), ['id'=>'product_id'])
			->viaTable('{{%product_tag}}', ['tag_id' => 'id'])
			->joinWith('i18n')
			->orderby('sort');
	}
	
	public function getCount() {
		return $this->getProducts()->count();
	}

	protected function getI18nClassname() {
		return I18nTag::className();
	}

	public static function tableName() {
		return '{{%tag_meta}}';
	}
	
}
