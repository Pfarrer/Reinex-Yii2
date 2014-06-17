<?php
namespace app\widgets;

use app\models\MetaImage;

use \yii\helpers\Url;

class ImageWidget extends \yii\base\Widget {

	private static $ROOT_DIR = 'img/cache';

	public static function thumbnail(MetaImage $img) {
		$x = 200; $y = 200;
		
		$dirpath = self::$ROOT_DIR.'/'.$x.'x'.$y;
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777, true) || die('ImageWidget::thumbnail(): mkdir failed');
		}
		
		$filepath = $dirpath.'/'.$img->hash.'.'.$img->extension;
		if (!is_file($filepath)) {
			self::createImage($img, $filepath, $x, $y, false);
		}
		
		return Url::base().'/'.$filepath;
	}
	
	private static function createImage(MetaImage $img, $targetpath, $x, $y, $overlay) {
	
		$image = \Yii::$app->image->load($img->fullPath());
		$image->resize($x, $y, \Yii\image\drivers\Image::AUTO);
		
		$image->save($targetpath, 98);
	
	}

	//public function run() {}
	
}

