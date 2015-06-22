<?php
namespace app\models;

use app\components\I18nModel;
use yii\helpers\ArrayHelper;

/**
 * Class ProductI18n
 *
 * @package app\models
 *
 * @property string name
 * @property string body
 * @property string shortcut_active
 * 
 * @property Shortcut shortcut
 * @property Shortcut[] shortcuts
 */
class DownloadI18n extends I18nModel
{
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name', 'body', 'shortcut_active'], 'filter', 'filter' => 'trim'],
			['shortcut_active', 'filter', 'filter' => 'strtolower'],
			['shortcut_active', 'trim'],
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
				Download ist aktuell erreichbar mit diesen Shortcuts: '.$shortcuts_str,
		];
	}
	
	public function getMeta()
	{
		return $this->hasOne(DownloadMeta::className(), ['id' => 'id']);
	}
	
	public function getShortcut()
	{
		return $this->hasOne(Shortcut::className(), ['shortcut' => 'shortcut_active'])
			->andWhere([
				'fmodel' => DownloadMeta::className(),
				'fid' => $this->id,
			]);
	}

	public function getShortcuts()
	{
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->andWhere(['fmodel' => DownloadMeta::className()]);
	}
	
	public function validate($attributeNames = null, $clearErrors = true)
	{
		$valid = parent::validate($attributeNames, $clearErrors);
		
		if (!empty($this->shortcut_active)) {
			// Check if shortcut is unique
			$existing_srtct = Shortcut::findOne(['shortcut' => $this->shortcut_active]);
			if ($existing_srtct) {
				if ($existing_srtct->fmodel == DownloadMeta::className() && $existing_srtct->fid == $this->id) {
					// Continue
				}
				else {
					$this->addError('shortcut_active', 'Shortcut wird bereits verwendet!');
					return false;
				}
			}
		}
		
		return $valid;
	}

	protected function getMetaClassname()
	{
		return DownloadMeta::className();
	}
}