<?php
namespace app\components;

use \Yii;
use yii\db\ActiveRecord;

use app\models\Shortcut;

/**
 * @property I18nModel i18nClassname
 * @property int id
 */
abstract class MetaModel extends ActiveRecord {

	public function getI18ns() {
		return $this->hasMany($this->i18nClassname, ['id' => 'id']);
	}

	public function getI18n() {
		return $this->hasOne($this->i18nClassname, ['id'=>'id'])
			->where('lang=:lang', [':lang'=>Yii::$app->language]);
	}
	
	public function getShortcuts() {
		return $this->hasMany(Shortcut::className(), ['fid' => 'id'])
			->where('fmodel=:fmodel', [':fmodel'=>self::className()]);
	}

	abstract protected function getI18nClassname();

} 
