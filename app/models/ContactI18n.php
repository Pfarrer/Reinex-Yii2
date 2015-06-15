<?php namespace app\models;

use app\components\I18nModel;

class ContactI18n extends I18nModel
{
	public function rules()
	{
		return [
			['department', 'required'],
			['department', 'filter', 'filter' => 'trim'],
		];
	}

	public function attributeLabels()
	{
		return [
			'department' => 'Abteilung',
			'tel' => 'Telefon',
			'mobile' => 'Handy',
		];
	}

	protected function getMetaClassname()
	{
		return ContactMeta::className();
	}
}