<?php
namespace app\assets;

use yii\web\AssetBundle;

class FittextAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [];
	public $js = [
		'js/jquery.fittext.js',
	];
	public $depends = [];
	
}
