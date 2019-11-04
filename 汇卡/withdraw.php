<?php
include 'Config.php';
include 'HttpUtils.php';
$data1 = [
	'version' 			=> 'V1.0',//协议版本
	'orgCode' 			=> '99999999',//机构号
	'merchCode' 		=> '105108100001655',//汇卡商户号
	'payType' 			=> 'withdraw_personal',//支付类型
	'merchOrderNo'		=> date('YmdHis').'005'.rand(10000,99999),//商户订单号
	'amount'	   		=> '100',//金额分为单位
	'accountType'		=> 'I2C',
	'accountName'		=> '刘科军',//客户姓名
	'accountCardNo'		=> '6214832026239553',//手机号
	'notifyUrl'			=> 'http://daishubao.aefzn.cn/',//异步地址
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
$url = 'http://113.108.195.242:3583/route/withdraw';
$headers = [];
// var_dump(json_encode($data, JSON_UNESCAPED_UNICODE));die;

$result = post($url, $headers, $data);
// $res = http($url,$data, 1);
file_put_contents('test.txt', $result.PHP_EOL, FILE_APPEND);
var_dump($result);die;
