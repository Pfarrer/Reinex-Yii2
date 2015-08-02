<?php
namespace app\widgets;

use app\models\DownloadMeta;
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
		return self::getImage($img->fullPath(), $img->extension, $img->hash, 120, 120, false);
	}

	public static function medium(Image $img)
	{
		return self::getImage($img->fullPath(), $img->extension, $img->hash, 200, 200, false);
	}

	public static function full(Image $img)
	{
		return self::getImage($img->fullPath(), $img->extension, $img->hash, 1024, 768, true);
	}

	public static function frontimage(Image $img)
	{
		return self::getImage($img->fullPath(), $img->extension, $img->hash, 1280, 720, false, 8);
	}

//	public static function fileThumbnail(DownloadMeta $download)
//	{
//		$dirpath = self::$ROOT_DIR . '/downloads';
//		if (!is_dir($dirpath)) {
//			mkdir($dirpath, 0777, true) || die('ImageWidget::fileThumbnail(): mkdir failed');
//		}
//
//		$filepath = $dirpath . '/'.$download->id.'.jpg';
//		if (!is_file($filepath)) {
//			$im = new \Imagick('uploads/files/'.$download->filename.'[1]');
//			$im->thumbnailImage(50, 200, true, true);
//			$im->setImageFormat('jpg');
//			$im->writeimage($filepath);
//		}
//
//		return Url::base() . '/' . $filepath;
//	}

	private static function getImage($fullPath, $extension, $hash, $x, $y, $overlay, $quality = 9)
	{
		$dirpath = self::$ROOT_DIR . '/' . $x . 'x' . $y;
		if (!is_dir($dirpath)) {
			mkdir($dirpath, 0777, true) || die('ImageWidget::getImage(): mkdir failed');
		}

		$filepath = $dirpath . '/' . $hash . '.' . $extension;
		if (!is_file($filepath)) {
			self::createImage($fullPath, $extension, $filepath, $x, $y, $overlay, $quality);
		}

		return Url::base() . '/' . $filepath;
	}

	private static function createImage($fullPath, $extension, $targetpath, $x, $y, $overlay, $quality)
	{
		$image = WideImage::load($fullPath);
		$image = $image->resize($x, $y);

		if ($overlay) {
			$upperWatermark = WideImage::load('images/watermark/top-left.png');
			$image = $image->merge($upperWatermark, 'left', 'top', 100);

			$lowerWatermark = WideImage::load('images/watermark/bottom-right.png');
			$image = $image->merge($lowerWatermark, 'right', 'bottom', 100);
		}


		if ($extension == 'jpg') $quality = $quality*10;

		$image->saveToFile($targetpath, $quality);
	}
}