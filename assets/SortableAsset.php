<?php
namespace app\assets;

use yii\web\AssetBundle;

class SortableAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [];
	public $js = [
		'js/jquery.sortable.min.js',
	];
	public $depends = [];
	
}
