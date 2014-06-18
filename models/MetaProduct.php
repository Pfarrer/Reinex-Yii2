<?php
namespace app\models;

/**
 * 
 **/
class MetaProduct extends \yii\db\ActiveRecord {

	public function getI18ns() {
        return $this->hasMany(I18nProduct::className(), ['id' => 'id']);
    }
    
    public function getI18n() {
        return $this->hasOne(I18nProduct::className(), ['id'=>'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }

	public function getFrontimage() {
		return $this->hasOne(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}

	public function getImages() {
		return $this->hasMany(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}
	
	public static function tableName() {
		return 'product_meta';
	}
	
}
