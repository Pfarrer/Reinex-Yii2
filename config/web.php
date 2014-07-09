<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

use yii\web\Response;

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
    	[
    		'class' => 'app\filters\LanguageNegotiator',
			'languageParam' => 'lang',
		],
    ],
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
    	'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
		'markdown' => [
			'class' => 'kartik\markdown\Module',
		],
        'db' => $db,
        'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'forceTranslation' => true,
				],
			],
		],
		'view' => [
			'class' => 'app\components\View',
		],
    ],
    'params' => $params,
];

if (false && YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
