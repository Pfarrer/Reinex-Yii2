<?php namespace app\widgets;

use app\components\Url;
use yii\bootstrap\BootstrapPluginAsset;

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
			['label' => 'Legal Notice', 'url' => Url::home().'#legal_notice', 'if' => \Yii::$app->language === 'de'],
		];
	}

	public static function admin()
	{
		return [
			['label' => 'Dashboard', 'url' => Url::to(['/admin'])],
			['label' => 'Frontimage', 'url' => Url::to(['/frontimage'])],
			['label' => 'Products', 'url' => Url::to(['/product'])],
			['label' => 'Tags', 'url' => Url::to(['/tag'])],
			['label' => 'Logout', 'url' => Url::to(['admin/logout']), 'icon' => 'log-out'],
		];
	}

	public function run()
	{
		BootstrapPluginAsset::register($this->view);
		$this->view->registerCssFile('css/menu.css');
		
		echo $this->render('navbar', ['items' => $this->items]);
	}
}