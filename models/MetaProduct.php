<?php
namespace app\models;

/**
 * 
 **/
class MetaProduct extends \yii\db\ActiveRecord {

	private $_i18n;

	public function getI18ns() {
        return $this->hasMany(I18nProduct::className(), ['id' => 'id']);
    }
    
    public function getI18n() {
        return $this->_i18n = $this->hasOne(I18nProduct::className(), ['id'=>'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
	
	public static function tableName() {
		return 'product_meta';
	}
	
}
