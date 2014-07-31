<?php
namespace app\widgets;

use \yii\helpers\Url;

class Menu extends \yii\base\Widget {

	public $items;

	public static function frontpage() {
		return [
			['label'=>'Products', 'url'=>Url::home().'#products'],
			['label'=>'Company', 'url'=>Url::home().'#company'],
			['label'=>'Contact', 'url'=>Url::home().'#contact'],
			['label'=>'Partners', 'url'=>Url::home().'#partners'],
			['label'=>'Legal Notice', 'url'=>Url::home().'#legal_notice', 'if'=>\Yii::$app->language==='de'],
		];
	}
	
	public static function admin() {
		return [
			['label'=>'Dashboard', 'url'=>Url::to(['/admin'])],
			['label'=>'Frontimage', 'url'=>Url::to(['/frontimage'])],
			['label'=>'Products', 'url'=>Url::to(['/product'])],
			['label'=>'Tags', 'url'=>Url::to(['/tag'])],
			['label'=>'Logout', 'url'=>Url::to(['admin/logout']), 'icon'=>'log-out'],
		];
	}

	public function run() {
		echo $this->render('menu', ['items'=>$this->items]);
	}
	
}

