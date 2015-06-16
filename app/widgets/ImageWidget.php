<?php
namespace app\widgets;

use app\models\Image;
use app\models\MetaImage;
use WideImage\WideImage;
use yii\base\Widget;
use yii\helpers\Url;
use Yii;

class ImageWidget extends Widget
{
	private static $ROOT_DIR = 'imgcache';

	public static function thumbnail(Image $img)
	{
		return self::getImage($img, 120, 120, false);
	}

	public static function medium(Image $img)
	{
		return self::getImage($img, 200, 200, false);
	}

	public static function full(Image $img)
	{
		return self::getImage($img, 1024, 768, true);
	}

	public static function frontimage(Image $img)
	{
		return self::getImage($img, 1280, 720, false, 7);
	}

	private static function getImage(Image $img, $x, $y, $overlay, $quality = 9)
	{
		$dirpath = self::$ROOT_DIR . '/' . $x . 'x' . $y;
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777, true) || die('ImageWidget::getImage(): mkdir failed');
		}

		$filepath = $dirpath . '/' . $img->hash . '.' . $img->extension;
		if (!is_file($filepath)) {
			self::createImage($img, $filepath, $x, $y, $overlay, $quality);
		}

		return Url::base() . '/' . $filepath;
	}

	private static function createImage(Image $img, $targetpath, $x, $y, $overlay, $quality)
	{
		$image = WideImage::load($img->fullPath());
		$image = $image->resize($x, $y);

		if ($overlay) {
			$upperWatermark = WideImage::load('images/watermark/top-left.png');
			$image = $image->merge($upperWatermark, 'left', 'top', 100);

			$lowerWatermark = WideImage::load('images/watermark/bottom-right.png');
			$image = $image->merge($lowerWatermark, 'right', 'bottom', 100);
		}


		if ($img->extension == 'jpg') $quality = $quality*10;

		$image->saveToFile($targetpath, $quality);
	}
}