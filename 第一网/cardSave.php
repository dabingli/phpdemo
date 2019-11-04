<?php
/**
 * 保存用户信息
 *
 * Created by PhpStorm.
 * User: Adi
 * Date: 2019/7/24
 * Time: 12:51
 */
include 'Config.php';
include 'HttpUtils.php';
include 'RSAUtils.php';

/**
 * 网申银行列表
 */
function card()
{
    $url = Config::$baseHost.'CreditCardInfo/CW/showCard';
    $md5String = Config::$merCode.Config::$secretKey;
    $chkValue = strtoupper(md5($md5String));
    $params = [
        'merCode' => Config::$merCode,
        'merMobile'=>'13679767985',
        'merIdentityNo'=>'130182198602071451',
        'merName'=>'张强',
        'bankCardId'=>'200013',
        'bankId'=>'809004',
        'externalRecord'=>'2019082915411',
    ];
    $str = Config::$merCode;
    foreach ($params as $key => $value) {
        if($key)
        $str .= $value;
    }
    $chkValue = strtoupper(md5($str));
    $headers = [];

    $result = post($url, $headers, $params);

    // print_r("请求结果\n");showCard
    print_r($result);
    // print_r(json_encode(json_decode($result), JSON_PRETTY_PRINT));

}

card();
print_r("\n");
