<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class MetaImage extends ActiveRecord {

	public function init() {
		parent::init();
		$this->on(self::EVENT_BEFORE_DELETE, [$this, 'handleBeforeDelete']);
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

	public function handleBeforeDelete($event) {
		// Falls das Image nur einmal benutzt wird -> Bild löschen
		if (MetaImage::find()->where(['hash'=>$this->hash])->count() == 1) {
			// Bild wird nirgends wo sonst benutzt
			@unlink('img/uploaded/'.$this->hash.'.'.$this->extension);
		}
	}

	public static function create(UploadedFile $file) {
		$img = new MetaImage();
		$img->hash = md5_file($file->tempName);
		$img->filename = $file->getBaseName();
		$img->extension = $file->getExtension();

		if ($file->saveAs('img/uploaded/'.$img->hash.'.'.$img->extension))
			return $img;

		return null;
	}

	public static function tableName() {
		return '{{%image_meta}}';
	}

}
