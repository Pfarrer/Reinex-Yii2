<?php namespace app\components;

use yii\db\ActiveRecord;

/**
 * @property MetaModel $metaClassName
 * @property int $id
 */
abstract class I18nModel extends ActiveRecord
{

	public function getMeta()
	{
		return $this->hasOne($this->metaClassName, ['id' => 'id']);
	}

	abstract protected function getMetaClassname();
}