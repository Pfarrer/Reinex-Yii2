<?php
namespace app\models;

use app\components\MetaModel;

class MetaProduct extends MetaModel {

	public function getFrontimage() {
		return $this->hasOne(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}
	public function getImages() {
		return $this->hasMany(MetaImage::className(), ['fid'=>'id'])
			->where('fmodel=:model', [':model' => $this::className()])
			->orderby('sort');
	}
	
	public function getParent() {
		return $this->hasOne(MetaProduct::className(), ['id'=>'parent_id']);
	}
	public function getChildren() {
		return $this->hasMany(MetaProduct::className(), ['parent_id'=>'id'])
			->orderby('sort');
	}
	
	public function rules() {
        return [
            [['parent_id'], 'validateParent'],
        ];
    }
    
    public function validateParent() {
    	if ($this->parent_id === NULL) return TRUE;
    	return $this->getParent() !== NULL;
    }
	
	protected function getI18nClassname() {
		return I18nProduct::className();
	}
	
	public static function tableName() {
		return 'product_meta';
	}
	
}
