<?php
namespace app\models;

use app\components\I18nModel;

class TagI18n extends I18nModel
{
	public function rules()
	{
		return [
			['name', 'required'],
			['body', 'safe'],
			['shortcut_active', 'filter', 'filter' => 'trim'],
			['shortcut_active', 'filter', 'filter' => 'strtolower'],
			['shortcut_active', 'string', 'max' => 30],
		];
	}

	public function attributeLabels()
	{
		return [
			'body' => 'Text',
		];
	}

	public function getShortcut()
	{
		return $this->hasOne(Shortcut::className(), ['shortcut' => 'shortcut_active']);
	}

	protected function getMetaClassname()
	{
		return TagMeta::className();
	}
}