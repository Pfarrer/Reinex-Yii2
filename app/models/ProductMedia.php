<?php
namespace app\models;

use Embed\Embed;
use yii\db\ActiveRecord;

class ProductMedia extends ActiveRecord
{
	private $_embed = null;

	public function rules()
	{
		return [
			[['product_id', 'url', 'name'], 'required'],
		];
	}

	public function getImage()
	{
		return $this->hasOne(Image::className(), ['fid' => 'id'])
			->where('fmodel=:model', [':model' => $this::className()]);
	}

	public function getEmbed()
	{
		if (!$this->_embed) {
			$this->_embed = Embed::create($this->url);
		}
		return $this->_embed;
	}
}