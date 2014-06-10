<?php
namespace app\models;

use \app\models\MetaProduct;

/**
 * 
 **/
class I18nTag extends \yii\db\ActiveRecord {

	public function getMeta() {
        return $this->hasOne(MetaTag::className(), ['id' => 'id']);
    }
    
    public function rules() {
        return [
            [['name'], 'required'],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'name' => 'Name',
		];
    }

	public static function tableName() {
		return 'tag_i18n';
	}
}
