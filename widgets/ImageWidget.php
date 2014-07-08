<?php
namespace app\widgets;

use app\models\MetaImage;

use \Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\image\drivers\Image;

class ImageWidget extends Widget {

	private static $ROOT_DIR = 'runtime/imgcache';

	public static function thumbnail(MetaImage $img) {
		return self::getImage($img, 120, 120, false);
	}

	public static function medium(MetaImage $img) {
		return self::getImage($img, 200, 200, false);
	}

	public static function full(MetaImage $img) {
		return self::getImage($img, 1280, 1024, true);
	}

	private static function getImage(MetaImage $img, $x, $y, $overlay) {
		$dirpath = self::$ROOT_DIR.'/'.$x.'x'.$y;
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777, true) || die('ImageWidget::thumbnail(): mkdir failed');
		}

		$filepath = $dirpath.'/'.$img->hash.'.'.$img->extension;
		if (!is_file($filepath)) {
			self::createImage($img, $filepath, $x, $y, $overlay);
		}

		return Url::base().'/'.$filepath;
	}
	
	private static function createImage(MetaImage $img, $targetpath, $x, $y, $overlay) {

		$image = Yii::$app->image->load($img->fullPath());
		$image->resize($x, $y, Image::AUTO);

		if ($overlay) {
			$upperWatermark = Image::factory('img/watermark/top-left.png');
			$image->watermark($upperWatermark, 0, 0, 90);

			$lowerWatermark = Image::factory('img/watermark/bottom-right.png');
			$image->watermark($lowerWatermark, TRUE, TRUE, 90);
		}
		
		$image->save($targetpath, 98);
	
	}

	//public function run() {}
	
}

