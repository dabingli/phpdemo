<?php
include 'Config.php';
include 'HttpUtils.php';
$data1 = [
	'version' 			=> 'V003',//协议版本
	'organNo' 			=> '99999999',//机构号
	'hicardMerchNo' 	=> '104403584003153',//汇卡商户号
	'payType' 			=> '050',//支付类型
	'bizType' 			=> '814',//商户业务类型
	'merchOrderNo'		=> date('YmdHis').'005'.rand(10000,99999),//商户订单号
	'customerName'		=> '刘科军',//客户姓名
	'cellPhoneNo'		=> '13005709476',//手机号
	'certType'			=> '01',//证件类型
	'certsNo'			=> '430503197809051514',//证件号
	'terminalType'		=> '01',//终端类型
	'Mac'	   			=> '34:2E:B6:97:9A:22',//移动端mac地址
	'cardNo'	   		=> '6226230592072670',//银行卡号
	'frontEndUrl'	   	=> 'http://daishubao.aefzn.cn',//前端回调url
	'backEndUrl'	   	=> 'http://daishubao.aefzn.cn/admin',//后台回调url
	'transIP'	   		=> '120.85.149.206',//交易IP
];
// $data1 = json_decode($json, 1);

$data = $data1;
ksort($data);
$str = '';
foreach($data as $k=>$v){
	if($v == '' || $k== 'sgin') continue;
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
$data['sign'] = md5($str);

$url = Config::$baseHost;
$url = $url.'InterfaceChangeServers/toMain.do';
$url = 'http://113.108.195.242:29993/hicardpay/order/TMBind';
$headers = [];
// var_dump(json_encode($data, JSON_UNESCAPED_UNICODE));die;

$result = post($url, $headers, $data);
// $res = http($url,$data, 1);
file_put_contents('test.txt', $result.PHP_EOL, FILE_APPEND);
var_dump($result);die;
