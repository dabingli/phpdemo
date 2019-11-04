<?php
include 'Config.php';
include 'HttpUtils.php';
$data1 = [
	'version' 			=> 'V1.0',//协议版本
	'orgCode' 			=> '99999999',//机构号
	'merchCode' 		=> '105108100001655',//汇卡商户号
	'payType' 			=> 'query_order',//类型
	'merchOrderNo' 		=> '2019101809061300539464',
	'createDate' 		=> date('Y-m-d'),//格式为：yyyy-MM-dd
	
];
// $data1 = json_decode($json, 1);

$data = $data1;
ksort($data);
$str = '';
foreach($data as $k=>$v){
	if($v == '' || $k== 'sign') continue;
	if($str != '') $str .= '&';
	if(is_array($v)){
		array_walk($v, function(&$value){
			ksort($value);
		});
		$v = json_encode($v);
	} 
	$str .= $k . '=' .$v;
}

$secretStr = 'ef775988943825d2871e1cfa75473ec0';
$str .= '&'.$secretStr;
// echo '<pre>';
// var_dump($str,md5($str));die;
$data['sign'] = strtoupper(md5($str));

$url = Config::$baseHost;
// $url = $url.'InterfaceChangeServers/toMain.do';
$url = 'http://113.108.195.242:3583/route/queryOrder';
$headers = [];
// var_dump(json_encode($data, JSON_UNESCAPED_UNICODE));die;

$result = post($url, $headers, $data);
// $res = http($url,$data, 1);
file_put_contents('test.txt', $result.PHP_EOL, FILE_APPEND);
var_dump($result);die;
