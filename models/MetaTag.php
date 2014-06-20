<?php
namespace app\models;

/**
 * 
 **/
class MetaTag extends \yii\db\ActiveRecord {

	public function getI18ns() {
        return $this->hasMany(I18nTag::className(), ['id' => 'id']);
    }
    
    public function getI18n() {
        return $this->hasOne(I18nTag::className(), ['id'=>'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
	
	public static function tableName() {
		return 'tag_meta';
	}
	
}
