<?php namespace app\widgets;

use app\models\ProductMeta;

class ProductList extends \yii\base\Widget
{
	public function run()
	{
		$this->view->registerCssFile('css/products.css');

		$products = ProductMeta::find()->orderby('sort')->all();
		return $this->render('product_list', [
			'products' => $products,
		]);
	}
}