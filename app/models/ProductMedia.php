<?php
namespace app\models;

use Embed\Embed;
use yii\db\ActiveRecord;

/**
 * Class ProductMedia
 *
 * @property int id
 * @property int product_id
 * @property int sort
 * @property string url
 * @property string name
 *
 * @property Image image
 */
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