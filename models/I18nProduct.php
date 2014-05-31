<?php
namespace app\models;

use \app\models\MetaProduct;

/**
 * 
 **/
class I18nProduct extends \yii\db\ActiveRecord {

	public function getMeta() {
        return $this->hasOne(MetaProduct::className(), ['id' => 'id']);
    }

	public static function tableName() {
		return 'product_i18n';
	}
}
