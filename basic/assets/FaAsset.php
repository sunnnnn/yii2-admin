<?php
namespace app\assets;

use yii\web\AssetBundle;

class FaAsset extends AssetBundle{
	
    public $sourcePath = '@app/components/assets/fa';
    public $css = [
        'css/font-awesome.min.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
