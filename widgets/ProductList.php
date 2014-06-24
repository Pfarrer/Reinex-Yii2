<?php
namespace app\widgets;

use \yii\helpers\Url;

class ProductList extends \yii\base\Widget {

	public $products;
	public $cols;

	public function run() {
		echo $this->render('product_list', [
			'products'=>$this->products,
			'cols' => $this->cols,
		]);
	}
	
}

