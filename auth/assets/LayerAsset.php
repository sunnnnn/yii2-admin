<?php
namespace sunnnnn\admin\auth\assets;

use yii\web\AssetBundle;

class LayerAsset extends AssetBundle{
	
	public $sourcePath = '@sunnnnn/admin/auth/components/assets/layer';
    public $css = [];
    public $js = [
    	'layer.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
