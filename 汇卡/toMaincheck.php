<?php
include 'Config.php';
include 'HttpUtils.php';
$request_no = 'R' . date('YmdHis') . rand(100000, 999999);
$data1 = [
	'AppHead'=>[
		'Version'=>'100',
		'TransType'=>'S1053',
		'DataTime'=>date('Y-m-d H:i:s'),
		'SerialNo'=>'201910121547275754'.rand(1000,9999),
	],
	'AppBody'=>[
		'institutionNo'=>'99999999',
		'extMerNo'=>'R20191021103839952041',
		'password'=>'1a861edc704121753369894d7afc9596',
		'Sign'=>'0581ba52cf01970e81137f3756f25b4c'
	]
];

// $data1 = json_decode($json, 1);

$data = $data1['AppBody'];
ksort($data);
$str = '';
foreach($data as $k=>$v){
	if($v == '' || $k== 'Sign') continue;
	if($str != '') $str .= '&';
	if(is_array($v)){
		array_walk($v, function(&$value){
			ksort($value);
		});
		$v = json_encode($v);
	} 
	$str .= $k . '=' .$v;
}

// $secretStr = '1a861edc704121753369894d7afc9596';
// $str .= '&'.$secretStr;

// echo '<pre>';
// var_dump($str,md5($str));die;
$data['Sign'] = md5($str);
$data1['AppBody']['Sign'] = md5($str);
// $data = json_encode($data);
// var_dump(json_encode($data1));die;

$url = Config::$baseHost;
$url = $url.'InterfaceChangeServers/toMain.do';
$headers = [];

$result = post($url, $headers, $data1);
file_put_contents('test.txt', '入件--'.$result.PHP_EOL, FILE_APPEND);
// $res = http($url,$data, 1);
var_dump($result);die;
