<?php
$config = [
	'id' => 'reinex',
	'basePath' => dirname(__DIR__),
	'vendorPath' => dirname(dirname(__DIR__)).'/vendor',
	'runtimePath' => dirname(dirname(__DIR__)).'/runtime',
	'bootstrap' => [
		'log',
		[
			'class' => 'app\components\LanguageNegotiator',
			'languageParam' => 'lang',
		],
	],
	'components' => [
		'request' => [
			'enableCsrfValidation' => true,
			'enableCookieValidation' => true,
			'cookieValidationKey' => ' ma23k3"_ lörm,2äop i90raSUdf oa kä3r-käsdFkpoa 0ipdfPq3',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
				],
			],
		],
		'view' => [
			'class' => 'app\components\View',
		],
		'db' => require(__DIR__.'/db.php'),
	],
	'params' => require(__DIR__.'/params.php'),
];

if (YII_ENV_DEV) {
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';
}

return $config;
