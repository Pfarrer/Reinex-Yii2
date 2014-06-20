<?php
namespace app\models;

use app\components\I18nModel;

class I18nProduct extends I18nModel {

    public function rules() {
        return [
            [['title', 'body'], 'required'],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'title' => 'Name',
    		'body' => 'Text',
    	];
    }
    
    protected function getMetaClassname() {
    	return MetaProduct::className();
    }

	public static function tableName() {
		return 'product_i18n';
	}
	
}
