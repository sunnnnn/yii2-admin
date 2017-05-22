<?php
namespace app\assets;

use yii\web\AssetBundle;

class LayerAsset extends AssetBundle{
	
	public $sourcePath = '@app/components/assets/layer';
    public $css = [
    ];
    public $js = [
    	'layer.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
