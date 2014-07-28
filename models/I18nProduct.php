<?php
namespace app\models;

use app\components\I18nModel;

class I18nProduct extends I18nModel {

    public function rules() {
        return [
            [['name', 'body'], 'required'],
            ['shortcut_active', 'filter', 'filter' => 'trim'],
            ['shortcut_active', 'filter', 'filter' => 'strtolower'],
            ['shortcut_active', 'string', 'max' => 30],
        ];
    }
    
    public function attributeLabels() {
    	return [
    		'body' => 'Text',
    	];
    }
    
	public function getShortcut() {
		return $this->hasOne(Shortcut::className(), ['shortcut' => 'shortcut_active']);
	}
	
	public function getShortcuts() {
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->andWhere('fmodel=:model', [':model'=>self::className()]);
	}
    
    protected function getMetaClassname() {
    	return MetaProduct::className();
    }

	public static function tableName() {
		return '{{%product_i18n}}';
	}
	
}
