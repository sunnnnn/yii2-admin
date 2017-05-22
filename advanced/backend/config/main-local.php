<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'bk5DQFxp8hGZNdn5P80S6Q_bksE4lVVZ',
        ],
    ],
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
	    			'sunnnnn-admin-curd' => '@backend/components/gii/generators/crud/default',
	    		]
	    	],
	    	'model' => [ //生成器名称
	    		'class' => 'yii\gii\generators\model\Generator',
	    		'templates' => [ //设置我们自己的模板
	    			//模板名 => 模板路径
	    			'sunnnnn-admin-model' => '@backend/components/gii/generators/model/default',
	    		]
	    	],
    	],
    ];
    /*******************************************************/
    
}

return $config;
