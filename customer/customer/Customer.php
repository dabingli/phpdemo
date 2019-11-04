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
function save()
{
    $rsaUtils = new RSAUtils(Config::convertPublicKey(Config::$publicKey), Config::convertPrivateKey(Config::$privateKey));
    $url = Config::$baseHost;
    $timestamp = Config::getMillisecond();
    
    $headers = Array(
        "X-Auth-OEM:" . Config::$oemID,
        // "X-Auth-Code:" . Config::$code,
        "X-Auth-Code:" . $_POST['code'],
        "X-Open-Merchant:" . Config::$merchant,
    );

    $params = [
        "user_name" => $_POST['user_name'],//用户昵称
        "mobile" => $_POST['mobile'],//用户昵称
        "real_name" => $_POST['real_name'],//用户昵称
        "identity" => $_POST['identity'],//用户昵称
        "unique_code" => $_POST['unique_code'],//用户昵称
        "is_authentication" => $_POST['is_authentication'],//用户昵称
    ];
    $params['sign'] = $rsaUtils->rsaSign($params);

    $result = post($url, $headers, $params);

    // print_r("请求结果\n");
    print_r($result);
    // print_r(json_encode(json_decode($result), JSON_PRETTY_PRINT));

}

 save();
print_r("\n");
