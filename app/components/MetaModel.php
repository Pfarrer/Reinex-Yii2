<?php namespace app\components;

use \Yii;
use yii\db\ActiveRecord;
use app\models\Shortcut;
use yii\db\Expression;

/**
 * @property int id
 *
 * @property string i18nClassname
 * @property I18nModel i18n
 * @property I18nModel i18n_any
 * @property I18nModel[] i18ns
 * @property Shortcut[] shortcuts
 */
abstract class MetaModel extends ActiveRecord
{

	public function getI18ns()
	{
		return $this->hasMany($this->i18nClassname, ['id' => 'id']);
	}

	public function getI18n()
	{
		return $this->hasOne($this->i18nClassname, ['id' => 'id'])
			->where('lang=:lang', [':lang' => Yii::$app->language]);
	}

	public function getI18n_any()
	{
		return $this->hasOne($this->i18nClassname, ['id' => 'id']);
	}

	public function getShortcuts()
	{
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->where('fmodel=:fmodel', [':fmodel' => self::className()]);
	}

	abstract protected function getI18nClassname();
}