<?php
namespace app\components;

class View extends \yii\web\View {

	public function init() {
		parent::init();
	}
	
	public function textile($raw) {
		$parser = new \Netcarver\Textile\Parser('html5');
		$parser->setRelativeImagePrefix(\yii\helpers\Url::base().'/img/');
		return $parser->textileThis($raw);
	}
}
