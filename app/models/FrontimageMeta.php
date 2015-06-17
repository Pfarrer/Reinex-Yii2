<?php
namespace app\models;

use app\components\MetaModel;

/**
 * Class FrontimageMeta
 *
 * @package app\models
 *
 * @property int image_id
 *
 * @property Image image
 */
class FrontimageMeta extends MetaModel
{
	public function rules()
	{
		return [
			['image_id', 'integer'],
		];
	}

	public function getImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'image_id']);
	}

	protected function getI18nClassname()
	{
		return FrontimageI18n::className();
	}
}