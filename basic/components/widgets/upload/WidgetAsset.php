<?php
namespace app\components\widgets\upload;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle{ 
    
    public $sourcePath = __DIR__;
    
    public $css = [
    ];
    
    public $js = [
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
