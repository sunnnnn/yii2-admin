<?php
namespace common\components\helpers;

class Curl{
	
	public function get($url, $httpHeader = [], $header = false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		if(!empty($httpHeader) && is_array($httpHeader)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}
		curl_close($ch);
		return $result;
	}
	
	public function post($url, $data, $httpHeader = [], $header = false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		if(!empty($httpHeader) && is_array($httpHeader)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}
		curl_close($ch);
		return $result;
	}
	
	public function put($url, $data, $header = false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-HTTP-Method-Override: put"]);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}
		curl_close($ch);
		return $result;
	}
	
	public function delete($url, $data, $header = false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-HTTP-Method-Override: delete"]);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}
		curl_close($ch);
		return $result;
	}
	
	public function request($url, $method, $data, $header = false, $headers = [], $cert = []){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		switch($method){
			case 'post': 
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				break;
			case 'put':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-HTTP-Method-Override: put"]);
				break;
			case 'delete':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-HTTP-Method-Override: delete"]);
				break;
			default: break;
		}
// 		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
// 		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
// 		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// 		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		if(!empty($headers) && is_array($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if(!empty($cert) && is_array($cert)){
			curl_setopt($ch, CURLOPT_SSLCERT, $cert['cert']);
			curl_setopt($ch, CURLOPT_SSLKEY,  $cert['key']);
		}
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}
		curl_close($ch);
		return $result;
	}
	
}