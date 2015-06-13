<?php namespace app\components;

use \Yii;
use yii\filters\ContentNegotiator;
use yii\web\Session;

class LanguageNegotiator extends ContentNegotiator
{
	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		// Session starten um zu prüfen ob eine Sprache eingesellt wurde
		$session = new Session();
		$session->open();
		if (isset($session['lang']) && Yii::$app->getRequest()->get($this->languageParam) === null) {
			$this->languages = [$session['lang']];
		}
		else {
			// Sprachen aus der Params-Config laden
			$this->languages = \Yii::$app->params['languages'];
		}

		parent::negotiate();

		if (\Yii::$app->getRequest()->get($this->languageParam) !== null) {
			$session['lang'] = \Yii::$app->language;
		}

		// Redirect auf die gleiche Seite aber ohne "lang" Parameter
		$params = Yii::$app->getRequest()->get();
		if (isset($params['lang'])) {
			unset($params['lang']);
			Yii::$app->controller = current(Yii::$app->createController(''));
			Yii::$app->controller->redirect(['/'.Yii::$app->getRequest()->getPathInfo()] + $params);
		}
	}
}