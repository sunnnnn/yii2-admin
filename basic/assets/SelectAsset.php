<?php
namespace app\assets;

use yii\web\AssetBundle;

class SelectAsset extends AssetBundle{
	
	public $sourcePath = '@app/components/assets/select2';
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
