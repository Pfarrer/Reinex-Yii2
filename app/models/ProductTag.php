<?php
namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class ProductTag
 *
 * @package app\models
 *
 * @property int product_id
 * @property int tag_id
 *
 * @property ProductMeta product
 * @property TagMeta tag
 */
class ProductTag extends ActiveRecord
{
	public function rules()
	{
		return [
			[['product_id', 'tag_id'], 'required'],
		];
	}

	public function getProduct()
	{
		return $this->hasOne(ProductMeta::className(), ['id' => 'product_id']);
	}
	public function getTag()
	{
		return $this->hasOne(TagMeta::className(), ['id' => 'tag_id']);
	}

	public static function primaryKey()
	{
		return ['product_id', 'tag_id'];
	}
}