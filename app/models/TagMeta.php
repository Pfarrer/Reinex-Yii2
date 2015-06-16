<?php
namespace app\models;

use app\components\MetaModel;

class TagMeta extends MetaModel
{
	public function getProducts()
	{
		return $this->hasMany(ProductMeta::className(), ['id' => 'product_id'])
			->viaTable('{{%product_tag}}', ['tag_id' => 'id'])
			->joinWith('i18n')->orderby('sort');
	}

	public function getCount()
	{
		return $this->getProducts()->count();
	}

	protected function getI18nClassname()
	{
		return TagI18n::className();
	}
}