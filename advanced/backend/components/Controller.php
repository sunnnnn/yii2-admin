<?php
namespace backend\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl as ACF;

class Controller extends \yii\web\Controller{
	
	/** ACF权限控制
	public function behaviors(){
		return [
			'access' => [
				'class' => ACF::className(),
				'rules' => [
					[
						'actions' => ['login', 'ajax-login'],
						'allow' => true,
					],
					[
						'allow' => true,
						'roles' => ['@'],
					]
				],
				'denyCallback' => function ($rule, $action) {}
			],
		];
	}
	*/
	
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