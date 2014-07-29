<?php
namespace app\models;

use app\components\I18nModel;

class I18nFrontimage extends I18nModel {
    
    public function rules() {
        return [
			[['name', 'body'], 'safe'],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'name' => 'Titel',
    		'body' => 'Text',
		];
    }

	protected function getMetaClassname() {
		return MetaFrontimage::className();
	}

	public static function tableName() {
		return '{{%frontimage_i18n}}';
	}

}
