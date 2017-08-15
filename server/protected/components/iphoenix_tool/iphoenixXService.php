<?php
class iPhoenixXService{	
	const URL= 'http://man.199x.net/includes/api.php';
	const USERNAME= 'Administrator';
	const PASSWORD= 'zLUn8Qo!BZitO6@a';
	public static function executeService($postfields){
		$postfields['username']= self::USERNAME;
		$postfields['password']= md5(self::PASSWORD);
		$postfields["responsetype"]= "json";
		$query_string = "";
		foreach ($postfields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$jsondata = curl_exec($ch);
		if (curl_error($ch)) die("Connection Error: ".curl_errno($ch).' - '.curl_error($ch));
		curl_close($ch);
		$result_arr = json_decode($jsondata);
		return $result_arr;
	}	
 
	public static function data() 
	{
		$request = file_get_contents('php://input');
		$data = array();
		if ($request) {
			if ($json_post = CJSON::decode($request)){
				$data = $json_post;
			}else{
				parse_str($request,$variables);
				$data = $variables;
			}
		}
		
		$list_params = array_merge($_GET,$_POST);

		foreach($list_params as $index=>$param){
			if ($param) {
				if(is_array($param)){
					$data[$index]=$param;
				}
				else{
					if (CJSON::decode($param)){
						$data[$index]=CJSON::decode($param);
					}else{
						$data[$index]=$param;
					}
				}
			}
		}
		return $data;
	}
}