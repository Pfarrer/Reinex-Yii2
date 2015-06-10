<?php
namespace app\models;

use app\components\MetaModel;
use yii\web\UploadedFile;

class MetaDownload extends MetaModel {

	public function fullPath() {
		return 'uploads/'.$this->hash.'.'.$this->extension;
	}
	
	public function getI18n() {
        return $this->hasOne(I18nDownload::className(), ['id' => 'id'])
        	->where('lang=:lang', [':lang'=>\Yii::$app->language]);
    }
    
    public function rules() {
        return [
            [['hash', 'filename', 'extension'], 'required'],
        ];
    }

	public static function create(UploadedFile $file) {
		$meta = new MetaDownload();
		$meta->hash = md5_file($file->tempName);
		$meta->filename = $file->getBaseName();
		$meta->extension = $file->getExtension();

		if ($file->saveAs('img/uploaded/'.$meta->hash.'.'.$meta->extension))
			return $meta;

		return null;
	}

	protected function getI18nClassname() {
		return I18nDownload::className();
	}

	public static function tableName() {
		return '{{%download_meta}}';
	}
}
