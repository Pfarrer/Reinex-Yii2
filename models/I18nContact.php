<?php
namespace app\models;

use app\components\I18nModel;

class I18nContact extends I18nModel {

    public function rules() {
        return [
            [['name', 'department'], 'required'],
            [['name', 'department', 'tel', 'mobile', 'mail', 'skype'], 'filter', 'filter' => 'trim'],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'department' => 'Abteilung',
    		'tel' => 'Telefon',
    		'mobile' => 'Handy',
    	];
    }
	
    protected function getMetaClassname() {
    	return MetaContact::className();
    }

	public static function tableName() {
		return 'contact_i18n';
	}
	
}
