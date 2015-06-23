<?php
namespace app\widgets;

use app\models\Image;
use app\models\MetaImage;
use WideImage\WideImage;
use yii\base\Widget;
use yii\helpers\Url;
use Yii;

class ImageUpload extends Widget
{
	/**
	 * @var array
	 */
	public $url;

	public function run()
	{
		return $this->render('image_upload', [
			'id' => $this->getId(),
			'url' => $this->url,
		]);
	}
}