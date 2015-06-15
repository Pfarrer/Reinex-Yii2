<?php namespace app\components;

use app\models\ProductMeta;
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

	public static function toProduct(ProductMeta $meta)
	{
		if ($meta->i18n && $meta->i18n->shortcut_active) return Url::to(['/'.$meta->i18n->shortcut_active]);
		else return Url::to(['/product/view', 'id'=>$meta->id]);
	}
}