<?php namespace app\widgets;

use app\components\Url;
use yii\bootstrap\BootstrapPluginAsset;
use Yii;

class Menu extends \yii\base\Widget
{
	private $items;

	public function init()
	{
		parent::init();
		
		$this->items = [
			['label' => 'Products', 'url' => Url::home().'#products'],
			['label' => 'Company', 'url' => Url::home().'#company'],
			['label' => 'Contact', 'url' => Url::home().'#contact'],
			['label' => 'Legal Notice', 'url' => Url::home().'#legal_notice', 'if' => Yii::$app->language === 'de'],
		];
	}

	public function run()
	{
		BootstrapPluginAsset::register($this->view);
		$this->view->registerCssFile('css/menu.css');
		
		echo $this->render('navbar', ['items' => $this->items]);
	}
}