<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle{
	
	public $sourcePath = '@common/components/assets/admin';
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/admin.css'
    ];
    public $js = [
    	'js/app.min.js',
    	'js/admin.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\LayerAsset',
        'backend\assets\FaAsset',
    ];
    
    public static function addJs($view, $jsfile) {
    	if(is_array($jsfile)){
    		foreach($jsfile as $js){
    			$view->registerJsFile($js, [AdminAsset::className(), 'depends' => AdminAsset::className()]);
    		}
    	}else{
    		$view->registerJsFile($jsfile, [AdminAsset::className(), 'depends' => AdminAsset::className()]);
    	}
    }
    
    public static function addCss($view, $cssfile) {
    	if(is_array($cssfile)){
    		foreach($cssfile as $css){
    			$view->registerCssFile($css, [AdminAsset::className(), 'depends' => AdminAsset::className()]);
    		}
    	}else{
    		$view->registerCssFile($cssfile, [AdminAsset::className(), 'depends' => AdminAsset::className()]);
    	}
    }
}
