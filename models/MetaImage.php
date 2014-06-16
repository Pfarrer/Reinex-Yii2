<?php

namespace app\models;

class MetaImage extends \yii\db\ActiveRecord {

	public function getI18n() {
        return $this->hasOne(I18nImage::className(), ['id' => 'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
    
    public function rules() {
        return [
            [['fid', 'ftype', 'path', 'md5'], 'required'],
        ];
    }
    
    public function attributeLabels() {
    	return [];
    }

	public static function tableName() {
		return 'image_meta';
	}

}
