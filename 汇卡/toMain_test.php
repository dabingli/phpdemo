<?php
include 'Config.php';
include 'HttpUtils.php';

$data1 = array (
  'AppHead' => 
  array (
    'Version' => '100',
    'TransType' => 'S1071',
    'DataTime' => '2019-10-20 14:56:04',
    'SerialNo' => '2019102014560494933',
  ),
  'AppBody' => 
  array (
    'InstitutionNo' => '99999999',
    'MerName' => '张锐康',
    'MerNameShort' => '张锐康',
    'MerchantType' => '1',
    'MerLegalName' => '张锐康',
    'MerLegalNo' => '441381199805054718',
    'MerLegalMobilePhone' => '13005709476',
    'MbiBankNo' => '303100000006',
    'MbiBankName' => '中国建设银行股份有限公司佛山季华支行',
    'MbiAccountNo' => '6228481136746049973',
    'MbiAccountUser' => '张锐康',
    'MbiAccountnoType' => '1',
    'MbiType' => '对私',
    'PosAreaCode' => '440300',
    'FeeParamList' => 
    array (
      0 => 
      array (
        'BusiNo' => '812',
        'Cardtype' => '0402',
        'RateNo' => '0.70',
      ),
    ),
    'Sign' => 'efdf3d56dd88367cf14d311eab668e39',
  ),
);

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

$secretStr = '1a861edc704121753369894d7afc9596';
$str .= '&'.$secretStr;
echo '<pre>';
var_dump($str,md5($str));die;
$data['Sign'] = md5($str);
$data1['AppBody']['Sign'] = md5($str);
// $data = json_encode($data);

$url = Config::$baseHost;
$url = $url.'InterfaceChangeServers/toMain.do';
$headers = [];

$result = post($url, $headers, $data1);
// $res = http($url,$data, 1);
var_dump($result);die;
