<?php
namespace app\assets;

use yii\web\AssetBundle;

class EditableAsset extends AssetBundle{
	
    public $sourcePath = '@app/components/assets/editable/bootstrap3-editable';
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
