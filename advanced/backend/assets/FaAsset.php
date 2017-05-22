<?php
namespace backend\assets;

use yii\web\AssetBundle;

class FaAsset extends AssetBundle{
	
    public $sourcePath = '@common/components/assets/fa';
    public $css = [
        'css/font-awesome.min.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
