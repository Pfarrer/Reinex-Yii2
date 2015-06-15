<?php
namespace app\models;

use yii\db\ActiveRecord;

class Image extends ActiveRecord
{
	public function init()
	{
		parent::init();
		$this->on(self::EVENT_BEFORE_DELETE, [$this, 'handleBeforeDelete']);
	}

	public function rules()
	{
		return [
			[['fid', 'fmodel', 'hash', 'extension'], 'required'],
		];
	}


	public function fullPath()
	{
		return "uploads/images/$this->hash.$this->extension";
	}

	public function handleBeforeDelete()
	{
		// Falls das Image nur einmal benutzt wird -> Bild löschen
		if (Image::find()->where(['hash' => $this->hash])->count() === 1) {
			// Bild wird nirgends wo sonst benutzt
			@unlink($this->fullPath());
		}
	}

//	public static function create(UploadedFile $file)
//	{
//		$img = new MetaImage();
//		$img->hash = md5_file($file->tempName);
//		$img->filename = $file->getBaseName();
//		$img->extension = $file->getExtension();
//		if ($file->saveAs('img/uploaded/' . $img->hash . '.' . $img->extension)) return $img;
//		return null;
//	}
}