<?php
namespace app\models;

use yii\web\UploadedFile;
use yii\base\Model;

class MetaImage extends \yii\db\ActiveRecord {

	public static function create(Model $model, UploadedFile $file) {
		$img = new MetaImage();
		$img->fid = $model->id;
		$img->fmodel = $model::className();
		$img->md5 = md5_file($file->tempName);
		$img->extension = $file->getExtension();
		
		if ($file->saveAs('img/uploaded/'.$img->md5.'.'.$img->extension) && $img->save())
			return $img;
		
		return null;
	}
	
	public function getI18n() {
        return $this->hasOne(I18nImage::className(), ['id' => 'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
    
    public function rules() {
        return [
            [['fid', 'fmodel', 'md5', 'extension'], 'required'],
        ];
    }
    
    public function attributeLabels() {
    	return [];
    }

	public static function tableName() {
		return 'image_meta';
	}

}
