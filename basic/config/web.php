<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'aDmSKKe_ZCto40TjAKpwaGedqqTSGfAM',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Admin', //修改管理员model类
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
        /****** sunnnnn/admin *******/
        'helper' => [
            'class' => 'sunnnnn\helper\Helper'
        ],
        /*************************************/
    ],
    'params' => $params,
    
    /****** sunnnnn/admin (rbac权限控制）*******/
    'modules' => [
    	'auth' => [
    		'class' => 'sunnnnn\admin\auth\Module',
    	]
    ],
    'as access' => [
    	'class' => 'sunnnnn\admin\auth\components\AccessControl',
    	'allowActions' => [
		    'site/login',
		    'site/ajax-login',
		    'site/error',
		    'debug/*',
		    'gii/*',
	    ]
    ],
    
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    /*************************************/
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    
    /******sunnnnn/admin 添加gii自动生成模板（model、curd）*******/
    $config['modules']['gii'] = [
	    'class' => 'yii\gii\Module',
	    'allowedIPs' => ['127.0.0.1', '::1'],
	    'generators' => [
		    'crud' => [ //生成器名称
		    	'class' => 'yii\gii\generators\crud\Generator',
		    	'templates' => [ //设置我们自己的模板
		    		//模板名 => 模板路径
		    		'sunnnnn-admin-curd' => '@app/components/gii/generators/crud/default',
		    	    'sunnnnn-admin-curd-ajax' => '@app/components/gii/generators/crud-ajax/default',
		    	]
	    	],
	    	'model' => [ //生成器名称
		    	'class' => 'yii\gii\generators\model\Generator',
		    	'templates' => [ //设置我们自己的模板
		    		//模板名 => 模板路径
		    		'sunnnnn-admin-model' => '@app/components/gii/generators/model/default',
		    	]
		    ],
	    ],
    ];
    /*******************************************************/
}

return $config;
