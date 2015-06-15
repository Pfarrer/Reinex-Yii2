<?php
namespace app\models;

use app\components\MetaModel;

class ProductMeta extends MetaModel
{
	public function init()
	{
		parent::init();
		$this->on(self::EVENT_BEFORE_DELETE, [$this, 'handleBeforeDelete']);
	}

	public function getImages()
	{
		return $this->hasMany(Image::className(), ['fid' => 'id'])
			->where('fmodel=:model', [':model' => $this::className()])->orderby('sort');
	}

	public function getFrontimage()
	{
		return $this->getImages()->limit(1);
	}

	public function getMedias()
	{
		return $this->hasMany(ProductMedia::className(), ['product_id' => 'id'])->orderby('sort');
	}

	public function getParent()
	{
		return $this->hasOne(MetaProduct::className(), ['id' => 'parent_id']);
	}

	public function getChildren()
	{
		return $this->hasMany(MetaProduct::className(), ['parent_id' => 'id'])->joinWith('i18n')->orderby('sort');
	}

	public function getTags()
	{
		return $this->hasMany(MetaTag::className(), ['id' => 'tag_id'])
		->viaTable('{{%product_tag}}', ['product_id' => 'id'])->joinWith('i18n')->orderby('name');
	}

	public function rules()
	{
		return [[['parent_id'], 'validateParent'],];
	}

	public function validateParent()
	{
		if ($this->parent_id === null) return true;
		return $this->getParent() !== null;
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
		return I18nProduct::className();
	}

	public static function tableName()
	{
		return '{{%product_meta}}';
	}

}