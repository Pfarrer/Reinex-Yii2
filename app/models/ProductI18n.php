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
class ProductI18n extends I18nModel
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
		return [
			'body' => 'Text kann mit Textile strukturiert werden. '.file_get_contents('../app/static/textile-help.txt'),
			'shortcut_active' => 'Der hier eingegebene Text kann benutzt werden um direkt auf die erstellte Seite zuzugreifen.
				Wenn man z.B. eine Hochdruckanlage erstellt und hier "hda" eingibt, erreicht man die Seite über die
				URL: reinex.de/hda<br />
				Produkt ist aktuell erreichbar mit diesen Shortcuts: '.
					join(', ', ArrayHelper::getColumn($this->meta->shortcuts, 'shortcut', false)),
		];
	}
	
	public function getMeta()
	{
		return $this->hasOne(ProductMeta::className(), ['id' => 'id']);
	}
	
	public function getShortcut()
	{
		return $this->hasOne(Shortcut::className(), ['shortcut' => 'shortcut_active'])
			->andWhere([
				'fmodel' => ProductMeta::className(),
				'fid' => $this->id,
			]);
	}

	public function getShortcuts()
	{
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->andWhere(['fmodel' => ProductMeta::className()]);
	}
	
	public function validate($attributeNames = null, $clearErrors = true)
	{
		$valid = parent::validate($attributeNames, $clearErrors);
		
		if (!empty($this->shortcut_active)) {
			// Check if shortcut is unique
			$existing_srtct = Shortcut::findOne(['shortcut' => $this->shortcut_active]);
			if ($existing_srtct) {
				if ($existing_srtct->fmodel == ProductMeta::className() && $existing_srtct->fid == $this->id) {
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
		return ProductMeta::className();
	}
}