<?php
namespace app\components;

use app\models\Shortcut;

class UrlManager extends \yii\web\UrlManager {

	public function parseRequest($request) {
		$shortcut = Shortcut::findOne(strtolower($request->getPathInfo()));
		if ($shortcut) return [$shortcut->action, ['id'=>$shortcut->fid]];
		else return parent::parseRequest($request);
	}

}
