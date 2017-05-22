<?php
namespace backend\assets;

use yii\web\AssetBundle;

class SelectAsset extends AssetBundle{
	
	public $sourcePath = '@common/components/assets/select2';
    public $css = [
    	'css/select2.min.css',
    ];
    public $js = [
    	'js/select2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
