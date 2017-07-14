<?php
namespace backend\assets;

use yii\web\AssetBundle;

class EditableAsset extends AssetBundle{
	
    public $sourcePath = '@common/components/assets/editable/bootstrap3-editable';
    public $css = [
        'css/bootstrap-editable.css',
    ];
    public $js = [
        'js/bootstrap-editable.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
