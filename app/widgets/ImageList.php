<?php namespace app\widgets;

use app\models\ProductMeta;

class ImageList extends \yii\base\Widget
{
	/**
	 * @var ProductMeta
	 */
	public $meta;

	public function run()
	{
		return $this->render('image_list', [
			'meta' => $this->meta,
		]);
	}
}