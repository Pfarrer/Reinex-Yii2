<?php
namespace app\models;

use app\components\I18nModel;

class FrontimageI18n extends I18nModel
{
	public function rules()
	{
		return [
			[['name', 'body'], 'string'],
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Titel',
			'body' => 'Text',
		];
	}

	protected function getMetaClassname()
	{
		return FrontimageMeta::className();
	}
}