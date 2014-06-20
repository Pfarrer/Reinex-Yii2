<?php
namespace app\models;

use app\components\I18nModel;

class I18nTag extends I18nModel {
    
    public function rules() {
        return [
            [['name'], 'required'],
			[['text'], 'safe'],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'name' => 'Name',
		];
    }

	protected function getMetaClassname() {
		return MetaTag::className();
	}

	public static function tableName() {
		return 'tag_i18n';
	}

}
