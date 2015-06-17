<?php namespace app\components;

use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string lang
 *
 * @property string metaClassName
 * @property MetaModel meta
 */
abstract class I18nModel extends ActiveRecord
{

	public function getMeta()
	{
		return $this->hasOne($this->metaClassName, ['id' => 'id']);
	}

	abstract protected function getMetaClassname();
}