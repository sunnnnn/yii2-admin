<?php
namespace app\components\helpers;

use Yii;
use yii\web\Response;

class Helper{
	
	public $getValueMethodGet = 'get';
	public $getValueMethodPost = 'post';
	public $getValueMethodHtml = 'html';
	
	public $outTypeJson  = Response::FORMAT_JSON;
	public $outTypeHtml  = Response::FORMAT_HTML;
	public $outTypeJsonp = Response::FORMAT_JSONP;
	public $outTypeRaw   = Response::FORMAT_RAW;
	public $outTypeXml   = Response::FORMAT_XML;
	
	
	public function getValue($method, $param, $default = 0, $filter = 'intval'){
		$value = null;
		switch($method){
			case $this->getValueMethodGet: 
				$value = Yii::$app->request->get($param);
				break;
			case $this->getValueMethodPost: 
				$value = Yii::$app->request->post($param);
				break;
			case $this->getValueMethodHtml:
				$value = (strpos($param, "\n") !== false) ? str_replace("\n", "<br/>", $param) : $param;
				break;
		}
		
		return empty($value) ? $default : (!empty($filter) && function_exists($filter) ? $filter($value) : $value);
	}
	
	public function out($type, $data = []){
		Yii::$app->response->format = $type;
		Yii::$app->response->data = $data;
		Yii::$app->response->send();
		exit;
	}
	
	public function isMobile(){
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
			return true;
		}
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA'])){
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;// 找不到为flase,否则为TRUE
		}
		// 判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = ['mobile', 'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh',
				'lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry',
				'meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi',
				'openwave','nexusone','cldc','midp','wap'
			];
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
				return true;
			}
		}
		if (isset ($_SERVER['HTTP_ACCEPT'])){ // 协议法，因为有可能不准确，放到最后判断
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
				return true;
			}
		}
		return false;
	}
	
	public function isWeChatBrowser(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}
		return false;
	}
}
