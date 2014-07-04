<?php
namespace app\models;

class ProductTag extends \yii\db\ActiveRecord {

    public function rules() {
        return [
            [['product_id', 'tag_id'], 'required'],
        ];
    }

	public static function tableName() {
		return 'product_tag';
	}
	
	public static function primaryKey() {
		return ['product_id', 'tag_id'];
	}

}
