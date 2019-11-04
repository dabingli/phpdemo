<?php
$data1 = [
	'AppHead'=>[
		'Version'=>'100',
		'TransType'=>'S1071',
		'DataTime'=>'2019-10-12 15:47:27',
		'SerialNo'=>'2019101215472757543909',
	],
	'AppBody'=>[
		'MerName'=>'商户名称商户名称商户名称',
		'MerNameShort'=>'商户简称',
		'MerAddress'=>'商户地址',
		'MerchantType'=>'01',
		'MerLegalName'=>'覃富锋',
		'MerLegalMobilePhone'=>'18646768716',
		'MerLegalNo'=>'130182198602071488',
		'LiquidateModle'=>'2',
		'InstitutionNo'=>'99999999',
		'MbiBankNo'=>'303100000006',
		'MbiBankName'=>'中国建设银行股份有限公司佛山季华支行',
		'MbiAccountNo'=>'6214831201048698',
		'MbiAccountUser'=>'覃富锋',
		'MbiAccountnoType'=>'1',
		'MbiType'=>'对私',
		'PosAreaCode'=>'440300',
		'FeeParamList'=>[
			[
				'BusiNo'=>'812',
				'Cardtype'=>'0414',
				'RateNo'=>'0.38',
				'RateT0float'=>'0.04',
			],
			[
				'BusiNo'=>'812',
				'Cardtype'=>'0414',
				'RateNo'=>'0.38',
				'RateT0float'=>'0.04',
			]
		],
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

$secretStr = '1a861edc704121753369894d7afc9596';
$str .= '&'.$secretStr;
echo '<pre>';
var_dump($str,md5($str));die;