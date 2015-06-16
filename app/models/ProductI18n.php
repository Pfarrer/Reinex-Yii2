<?php
namespace app\models;

use app\components\I18nModel;

/**
 * Class ProductI18n
 *
 * @package app\models
 *
 * @property string name
 * @property string body
 * @property string shortcut_active
 */
class ProductI18n extends I18nModel
{
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name', 'body', 'shortcut_active'], 'filter', 'filter' => 'trim'],
			['shortcut_active', 'filter', 'filter' => 'strtolower'],
			['shortcut_active', 'string', 'max' => 30],
		];
	}

	public function attributeLabels()
	{
		return [
			'body' => 'Text',
			'shortcut_active' => 'Shortcut',
		];
	}

	public function attributeHints()
	{
		return [
			'body' => 'Text kann mit Textile strukturiert werden.'.file_get_contents('../app/static/textile-help.txt'),
			'shortcut_active' => 'Der hier eingegebene Text kann benutzt werden um direkt auf die erstellte Seite zuzugreifen.
				Wenn man z.B. eine Hochdruckanlage erstellt und hier "hda" eingibt, erreicht man die Seite über die
				URL: reinex.de/hda',
		];
	}

	public function getShortcut()
	{
		return $this->hasOne(Shortcut::className(), ['shortcut' => 'shortcut_active']);
	}

	public function getShortcuts()
	{
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->andWhere('fmodel=:model', [':model' => self::className()]);
	}

	protected function getMetaClassname()
	{
		return ProductMeta::className();
	}
}