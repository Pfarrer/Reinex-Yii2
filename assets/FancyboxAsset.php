<?php
namespace app\assets;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'js/fancybox/jquery.fancybox.css',
	];
	public $js = [
		'js/fancybox/jquery.fancybox.pack.js',
	];
	public $depends = [];
	
}
