<?php
namespace common\components\utils;

use Yii;

class Ip {
	public static function getIP(){
		static $realip;
		if (isset($_SERVER)){
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if (getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			} else if (getenv("HTTP_CLIENT_IP")) {
				$realip = getenv("HTTP_CLIENT_IP");
			} else {
				$realip = getenv("REMOTE_ADDR");
			}
		}
		
		return $realip;
	}
	
	public static function getArea(){
		$ip = self::getIP();
		
		$url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
		$area = Yii::$app->curl->get($url);
		$area = json_decode($area, true);
		if($area['code'] == '1' || empty($area['data']) || empty($area['data']['area_id'])){
			$area['data'] = self::getAreaIp();
		}
		
		return $area['data'];
	}
	
	public static function getAreaIp(){
		$url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
		$area  = Yii::$app->curl->get($url);
		$area = json_decode($area, true);
		return $area;
	}
	
}