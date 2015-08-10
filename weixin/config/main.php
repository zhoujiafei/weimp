<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'weixin-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'weixin\controllers',
    'language' => 'zh-CN',
	'defaultRoute' => 'weixin',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
        ],
        'wechat' => [
            'class' => 'weixin\components\WeChat',
            'options' => [
		         'token'=>'hello', //填写你设定的key
             	 'appid'=>'wx33eb06d17efee6ec', //填写高级调用功能的app id
                 'appsecret'=>'2ba8857725fb1e34210132776133591a' //填写高级调用功能的密钥
		     ],
        ],
        'errorHandler' => [
            'errorAction' => 'weixin/error',
        ],
    ],
    'params' => $params,
];
