<?php namespace app\components;

class View extends \rmrevin\yii\minify\View
{
	public function textile($raw)
	{
		$parser = new \Netcarver\Textile\Parser('html5');
		$parser->setRelativeImagePrefix(\yii\helpers\Url::base().'/');
		return $parser->textileThis($raw);
	}
}