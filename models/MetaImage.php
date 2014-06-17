<?php
namespace app\models;

use yii\web\UploadedFile;
use yii\base\Model;

class MetaImage extends \yii\db\ActiveRecord {

	public static function create(Model $model, UploadedFile $file) {
		$img = new MetaImage();
		$img->fid = $model->id;
		$img->fmodel = $model::className();
		$img->hash = md5_file($file->tempName);
		$img->filename = $file->getBaseName();
		$img->extension = $file->getExtension();
		
		if ($file->saveAs('img/uploaded/'.$img->hash.'.'.$img->extension) && $img->save())
			return $img;
		
		return null;
	}
	
	public function fullPath() {
		return 'img/uploaded/'.$this->hash.'.'.$this->extension;
	}
	
	public function getI18n() {
        return $this->hasOne(I18nImage::className(), ['id' => 'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
    
    public function rules() {
        return [
            [['fid', 'fmodel', 'hash', 'extension'], 'required'],
        ];
    }

	public static function tableName() {
		return 'image_meta';
	}

}
