<?php
namespace backend\assets;

use yii\web\AssetBundle;

class DtPickerAsset extends AssetBundle{
	
	public $sourcePath = '@common/components/assets/dtpicker';
    public $css = [
    	'css/bootstrap-datetimepicker.min.css'
    ];
    public $js = [
    	'js/bootstrap-datetimepicker.min.js',
    	'js/locales/bootstrap-datetimepicker.zh-CN.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
