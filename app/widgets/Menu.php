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
			['label' => 'Welcome', 'url' => Url::home().'#welcome', 'if' => $this->getView()->body_background_image_url !== null],
			['label' => 'Products', 'url' => Url::home().'#products'],
			['label' => 'Downloads', 'url' => Url::home().'#downloads'],
			['label' => 'Company', 'url' => Url::home().'#company'],
			['label' => 'Contact', 'url' => Url::home().'#contact'],
			['label' => 'Legal Notice', 'url' => Url::home().'#legal_notice', 'if' => Yii::$app->language === 'de'],
		];
	}

	public function run()
	{
		BootstrapPluginAsset::register($this->view);
		$this->view->registerCssFile(Url::base().'/css/menu.css');
		
		echo $this->render('navbar', ['items' => $this->items]);
	}
}