<?php
namespace app\assets;

use yii\web\AssetBundle;

class FullpageAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/jquery.fullPage.css',
	];
	public $js = [
		'js/jquery.easings.min.js',
		'js/jquery.slimscroll.min.js',
		'js/jquery.fullPage.min.js',
	];
	public $depends = [];
}
