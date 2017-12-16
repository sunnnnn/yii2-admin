<?php
namespace backend\components\widgets\import;

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
        'backend\assets\LayerAsset'
    ];
}
