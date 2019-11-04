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
        'chkValue' => $chkValue
    ];
    $headers = [];

    $result = post($url, $headers, $params);

    // print_r("请求结果\n");showCard
    print_r($result);
    // print_r(json_encode(json_decode($result), JSON_PRETTY_PRINT));

}

card();
print_r("\n");
