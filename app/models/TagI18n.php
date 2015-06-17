<?php
namespace app\models;

use app\components\I18nModel;
use yii\helpers\ArrayHelper;

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
			'shortcut_active' => 'Shortcut',
		];
	}

	public function attributeHints()
	{
		$shortcuts = $this->meta ? $this->meta->shortcuts : [];
		$shortcuts_str = join(', ', ArrayHelper::getColumn($shortcuts, 'shortcut', false));

		return [
			'body' => 'Text kann mit Textile strukturiert werden. '.file_get_contents('../app/static/textile-help.txt'),
			'shortcut_active' => 'Der hier eingegebene Text kann benutzt werden um direkt auf die erstellte Seite zuzugreifen.
				Wenn man z.B. die Kategorie Reinigen erstellt und hier "reinigen" eingibt, erreicht man die Seite über die
				URL: reinex.de/reinigen<br />
				Kategorie ist aktuell erreichbar mit diesen Shortcuts: '.$shortcuts_str,
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