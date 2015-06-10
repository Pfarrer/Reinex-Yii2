<?php
namespace app\models;

use app\components\I18nModel;

class I18nDownload extends I18nModel {
    
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
		return MetaDownload::className();
	}

	public static function tableName() {
		return '{{%download_i18n}}';
	}

}
