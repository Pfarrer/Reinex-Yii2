<?php namespace app\components;

use yii\helpers\BaseUrl;

class Url extends BaseUrl
{
	public static function switchLanguageUrl($lang)
	{
		$current = self::to();
		if (strpos($current, '?') === FALSE) {
			$seperator = '?';
		}
		else {
			$seperator = '&';
		}

		return $current.$seperator.'lang='.$lang;
	}
}