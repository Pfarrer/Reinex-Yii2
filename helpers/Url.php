<?php
namespace app\helpers;

class Url extends \yii\helpers\BaseUrl {

	public static function switchLanguageUrl($lang) {

		$current = self::canonical();

		if (strpos($current, '?') === FALSE) $seperator = '?';
		else $seperator = '&';

		return $current.$seperator.'lang='.$lang;

	}

}
