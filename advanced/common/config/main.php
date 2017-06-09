<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'helper' => [
        	'class' => 'sunnnnn\helper\Helper'
		],
    ],
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
];
