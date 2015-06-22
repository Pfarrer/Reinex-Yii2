<?php namespace app\assets;

use yii\web\AssetBundle;

class MasonryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
		'js/masonry.pkgd.min.js',
		'js/imagesloaded.pkgd.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
