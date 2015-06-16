<?php
namespace app\widgets;

use yii\base\Widget;

class GoBackButton extends Widget
{
	public function run()
	{
		$text = \Yii::t('common', 'Go back');
		echo "<button class=\"btn btn-default pull-left\" onclick=\"history.go(-1)\">
			$text
		</button>";
	}
}