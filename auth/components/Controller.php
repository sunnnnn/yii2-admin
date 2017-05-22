<?php
namespace sunnnnn\admin\auth\components;

use Yii;
use yii\helpers\ArrayHelper;

class Controller extends \yii\web\Controller{
	
	public function init(){
		parent::init();
	}
	
	public function getPostValue($param, $default = 0, $filter = 'intval'){
		return Yii::$app->helper->getValue(Yii::$app->helper->getValueMethodPost, $param, $default, $filter);
	}
	
	public function getGetValue($param, $default = 0, $filter = 'intval'){
		return Yii::$app->helper->getValue(Yii::$app->helper->getValueMethodGet, $param, $default, $filter);
	}
	
	public function outAjaxForm($url, $message = ''){
		Yii::$app->helper->out(Yii::$app->helper->outTypeJson, ['url' => $url, 'message' => $message]);
	}
	
	public function outAjaxRequest($status = true, $message = '', $ext = []){
		$data = [
			'status' => $status ? '1' : '0',
			'message' => $message
		];
		if(!empty($ext) && is_array($ext)) $data = ArrayHelper::merge($data, $ext);
		Yii::$app->helper->out(Yii::$app->helper->outTypeJson, $data);
	}
	
}