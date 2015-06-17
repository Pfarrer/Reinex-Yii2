<?php namespace app\widgets;

use app\models\ProductMeta;

class ProductList extends \yii\base\Widget
{
	/**
	 * @var ProductMeta[]
	 */
	public $products;

	public function run()
	{
		$this->view->registerCssFile('css/products.css');

		return $this->render('product_list', [
			'products' => $this->products,
		]);
	}
}