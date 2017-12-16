<?php
namespace app\components\widgets\import;

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
        'app\assets\LayerAsset'
    ];
}
