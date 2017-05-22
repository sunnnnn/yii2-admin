<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'helper' => [
        	'class' => 'common\components\helpers\Helper'
		],
		'curl' => [
			'class' => 'common\components\helpers\Curl'
		],
    ],
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
];
