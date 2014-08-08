<?php
namespace app\assets;

use yii\web\AssetBundle;

class ProductSortAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [];
	public $js = [
		'js/product_sort.js',
	];
	public $depends = [
		'kartik\sortable\SortableAsset',
	];
	
}
