<?php namespace app\components;

use app\models\FrontimageMeta;
use app\widgets\ImageWidget;
use yii\db\Expression;

class View extends \rmrevin\yii\minify\View
{
	public $body_background_image_url;

	public function init()
	{
		parent::init();

		// Pick Frontimage
		$frontimage = FrontimageMeta::find()->joinWith('i18n')->orderBy(new Expression('RAND()'))->one();
		if ($frontimage) {
			$this->body_background_image_url = ImageWidget::frontimage($frontimage->image);
		}
	}

	public function textile($raw)
	{
		$parser = new \Netcarver\Textile\Parser('html5');
		$parser->setRelativeImagePrefix(\yii\helpers\Url::base().'/');
		return $parser->textileThis($raw);
	}
}