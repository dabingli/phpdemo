<?php

$url = 'http://www.daishubao.com/api/v1/credit/regchannel';
$rawData = 'merchant_name=%E5%BC%A0%E9%94%90%E5%BA%B7&id_card_no=441381199805054718&bank_mobile=13005709476&bank_cardno=6221660078342871&expired=2501&cvn2=983&repayment_date=22&bill_date=10&channel_type=quick&rate=0.0080&tfee=1';
$isheader = '1';
$headerarr = ['token:7f634715638526320c3221b9d12aa084'];
curl_post_raw($url, $rawData, $isheader, $headerarr);

function curl_post_raw($url, $rawData,$isheader= 0,$headerarr=[])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if ($isheader == 0) {
        curl_setopt($ch, CURLOPT_HEADER, false);
    } else {
        //header数据
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerarr);
    }
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    $data = curl_exec($ch);
    curl_close($ch);
    var_dump($data);die;
    return $data;
}

// $data = [
//     'productinfo' => [
//         'pid'=>['5', '2'],
//         'num'=>['3', '1']
//     ],
//     'type' => 'cart'
// ];
// var_dump(json_encode($data));die;

$data1 = [
	'MerName'=>'科技技术有限公司test',
	'MbiAccountUser'=>'逢爱琴',
	'MbiType'=>'对私',
	'MerchantType'=>'01',
	'MerLegalNo'=>'130182198602071452',
	'MerLegalMobilePhone'=>'18646768715',
	'LiquidateModle'=>'2',
	'MerLegalName'=>'逢爱琴',
	'InstitutionNo'=>'99999999',
	'MbiBankNo'=>'303100000006',
	'MerAddress'=>'合作区前湾一路1号',
	'MerNameShort'=>'测试托尔斯泰',
	'MbiBankName'=>'中国光大银行',
	'MbiAccountNo'=>'3568390068493413',
	'PosAreaCode'=>'440300',
	'MbiAccountnoType'=>'1',
	'Sign'=>'19f2c655b15dd69cdf27fc52d994fd6c',
	'FeeParamList' => []
];


$data = $data1;
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

$jsondata['AppHead'] = $data1;
