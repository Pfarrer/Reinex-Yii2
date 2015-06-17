<?php
namespace app\models;

use app\components\MetaModel;

/**
 * Class ProductMeta
 *
 * @property int id
 * @property int sort
 * @property int|null parent_id
 *
 * @property ProductI18n i18n
 * @property ProductMeta parent
 * @property Image[] images
 * @property ProductMedia[] metias
 */
class ProductMeta extends MetaModel
{
	public function init()
	{
		parent::init();
		$this->on(self::EVENT_BEFORE_DELETE, [$this, 'handleBeforeDelete']);
	}

	public function rules()
	{
		return [
			['sort', 'integer'],
			['parent_id', 'validateParent'],
		];
	}

	public function validateParent()
	{
		if ($this->parent_id === null) return true;
		return $this->getParent() !== null;
	}

	public function getImages()
	{
		return $this->hasMany(Image::className(), ['fid' => 'id'])
			->where('fmodel=:model', [':model' => $this::className()])->orderby('sort');
	}

	public function getFrontimage()
	{
		return $this->getImages()->limit(1)->one();
	}

	public function getMedias()
	{
		return $this->hasMany(ProductMedia::className(), ['product_id' => 'id'])->orderby('sort');
	}

	public function getParent()
	{
		return $this->hasOne(ProductMeta::className(), ['id' => 'parent_id']);
	}

	public function getChildren()
	{
		return $this->hasMany(ProductMeta::className(), ['parent_id' => 'id'])->joinWith('i18n')->orderby('sort');
	}

	public function getTags()
	{
		return $this->hasMany(TagMeta::className(), ['id' => 'tag_id'])
			->viaTable('{{%product_tag}}', ['product_id' => 'id'])->joinWith('i18n')->orderby('name');
	}

	public function handleBeforeDelete($event)
	{
		foreach ($this->images as $img) {
			/* @var $img \app\models\MetaImage */
			$img->delete();
		}
	}

	protected function getI18nClassname()
	{
		return ProductI18n::className();
	}
}