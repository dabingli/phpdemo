<?php
require_once dirname(__FILE__) . '\service.php';

/**
 * P7带原文消息签名
 * @param array $order 订单参数
 * @return json 签名后的base64编码
 */
function sign($order)
{
    $cert_base64 = '';
    $key_index = '';
    $pfx_path = dirname(__FILE__) . '\cert.pfx';
    $fp = fopen($pfx_path, 'rb');
    $pfx_content = fread($fp, filesize($pfx_path));
    fclose($fp);
    $pfx_base64 = base64_encode($pfx_content);
    $order_base64 = base64_encode(json_encode($order));
    try {
        $result = lajpCall("cfca.sadk.api.CertKit::getCertFromPFX", $pfx_base64, '888888');
        $result = json_decode($result);
        $cert_base64 = $result->Base64CertString;
    } catch (Exception $e) {
        echo $e;
        // Log::info($e);
    }
    // 密钥索引
    $kit_result = lajpCall("cfca.sadk.api.KeyKit::getPrivateKeyIndexFromPFX", $pfx_base64, '888888');
    $key_index = json_decode($kit_result)->privateKeyIndex;
    // P7带原文消息签名
    $sign_result = lajpCall("cfca.sadk.api.SignatureKit::P7SignMessageAttach", 'sha256WithRSAEncryption', $order_base64, $key_index, $cert_base64);
    return json_decode($sign_result)->Base64CertString;
}
/**
 * P7带原文消息验签
 * @param  string $check_value P7签名后的编码
 * @return object $result 验签结果
 */
function verify($check_value)
{
    $check_value = urldecode($check_value);
    $verify_result = lajpCall(
        "cfca.sadk.api.SignatureKit::P7VerifyMessageAttach", $check_value);
    $result = json_decode($verify_result)->Base64Source;
    $result = json_decode(base64_decode(base64_decode($result)));
    return $result;
}
//订单数据
$order = array(
    "devsId"=> "10210180009515128",
    "legalName"=> "张三",
    "extSeqId"=> "1561947128155",
    "mobileMask"=> "1800000****",
    "agentNo"=> "3100045000000084",
    "agentName"=> "代理商开钱三",
    "activationTime"=> "20180508142602",
    "IdnoMask"=> "2106031998******21",
    "userLevel"=> "52",
    "merchantName"=> "美国进口",
    "method"=> "MemberActivation",
    "merchantNo"=> "3100016000061735"
);
// P7签名
$sign = sign($order);
echo hash('sha256', $sign).'<br>';
echo var_dump($sign) . '<br>';
echo var_dump('a4ee55e33d2b3ddc95b97da1f79572ff916e4633872d7bee364548946bbc3107').'<br>';
// echo strlen('a4ee55e33d2b3ddc95b97da1f79572ff916e4633872d7bee364548946bbc3107');
// 验签平台返回数据
$result = 'TUlJSXNnWUpLb1pJaHZjTkFRY0NvSUlJb3pDQ0NKOENBUUV4RHpBTkJnbGdoa2dCWlFNRUFnRUZBRENDQXJNR0NTcUdTSWIzRFFFSEFhQ0NBcVFFZ2dLZ1pYbEtlVnBZVG5kWU1sSnNZekpOYVU5cFRHdDFjVlJ0YlVwUWJXbEtSR3hwY0RocFRFTkthVm94T1hsYVdGSm1aRmhLYzBscWIybGhTRkl3WTBSdmRreDZSWGhQVXpSNVQxTTBlRTFVUlhWT1ZFVjJZMjFXYWxwWGJESmFVelYzWVVoQmFVeERTbXBpVjFKbVlWZFJhVTlwU1hsTlJGRnBURU5LYTJGWVdtWmFSMVl3V1Zkc2MwbHFiMmxYTTNSalNXMVNjR1JyVGpGak0xSktXa1ozYVU5c2QybE9hbGt5VG1wQmQwMUVRWGROUkVGM1RucFplVTlXZDJsTVJuZHBXa2RzTWxGWFRtcGtSV3hyV0VOSk5saERTVE5QVkZFeFdFTkpjMWhEU210aFdGcENZbGhTWTBscWNHTkphbGwzVEdwQmQxaERTWE5ZUTBwcllWaGFSMk50Vm14bGJWWkhXakYzYVU5c2QybE5SRUpqU1c0eFpFbHBkMmxqUjNob1pFZGFkbU50TVdaak1sWjRXREpzYTBscWIybE5ha0Y0VG5wQmVVMUVUWGROUkVGM1RVUkJkMDVVUVhoSmFYZHBaRWhLYUdKdVRtWlpWekV3U1dwdmFVNXFRWFZOUkVGcFRFTktkbU50VW14amJEbHdXa05KTmtscVNYZE5lbXN5VGxSbk5FNTZSbWhaTWxrelRXMVpOVTVUU1hOSmJsWjZXbGhLWmxrelZucGtSamx3V2tOSk5rbHFXVEpPYWxsM1RVUkJkMDFFUVhkTlJHTTBUbnBKYVV4RFNteGxTRkpzWW01T2NHSXlOR2xQYVVscFRFTktibGxZVW14WU1teHJTV3B2YVUxRWEybE1RMHA1V2xoT2QxZ3lUblphUjFWcFQybEplVTFFVVhkTlJFRnBURU5LZEZwWVNtWmpTRXB3WkdsSk5rbHBTWE5KYlRsNVdrZFdlVmd5VW1oa1IxVnBUMmxKZVUxRVJUTk5SRWwzVFhsSmMwbHRNV3hqYkRscVpGaE9NRmd5Ykd0SmFtOXBUbXBaTWs1cVFYZE5SRUYzVFVSQmQwNTZXWGxQVTBselNXNUtiR1JHT1RGamJYZHBUMmxLYjJSSVVuZFBhVGgyVFZSRk5VeHFTVFZNYWtWNFRWTTBNVTFUT1hsYVYwNXNZVmhhYkV4dVFtOWpRMG81b0lJRVFEQ0NCRHd3Z2dNa29BTUNBUUlDQlJBQ1NUVVlNQTBHQ1NxR1NJYjNEUUVCQlFVQU1GZ3hDekFKQmdOVkJBWVRBa05PTVRBd0xnWURWUVFLRXlkRGFHbHVZU0JHYVc1aGJtTnBZV3dnUTJWeWRHbG1hV05oZEdsdmJpQkJkWFJvYjNKcGRIa3hGekFWQmdOVkJBTVREa05HUTBFZ1ZFVlRWQ0JQUTBFeE1CNFhEVEUxTVRBeU56QTNNVEl3TlZvWERUSXdNVEF5TnpBM01USXdOVm93ZXpFTE1Ba0dBMVVFQmhNQ1EwNHhGVEFUQmdOVkJBb1RERU5HUTBFZ1ZFVlRWQ0JEUVRFUk1BOEdBMVVFQ3hNSVRHOWpZV3dnVWtFeEdUQVhCZ05WQkFzVEVFOXlaMkZ1YVhwaGRHbHZibUZzTFRFeEp6QWxCZ05WQkFNTUhqQTFNVUF4TURBd01ERjg1ckdINUx1WTVwV3c1bzJ1UUZwNGVIaEFNVENDQVNJd0RRWUpLb1pJaHZjTkFRRUJCUUFEZ2dFUEFEQ0NBUW9DZ2dFQkFLeS9OUmo3ZmpJVkF5Y0FiWFk0OSsyS1ErOThVOWJMckxJdEJ1LzBDYXBGRzNnUm8xbENvUlNPb1lDTDEzYndLRU15WWJKOHVqRVlDR2hVMVo0RmY0QTA4V05odVdWZC9zaXBTVW5mZ01VbFBQYi8rTzFzdnUxWjJTREhyd0NHbStoc3hhazQvZzFJWGFtbzE5UWswbFU0ZVJPQ3pCVHlOQXdYN0VhWU4zVjBtaDk1V2RkV0ZFeTJTUGgva3JmUGkvZHFBbFVvMjdBZFV1TjFMa3doNWdSQXJhVnZPenV2bXBlZDNJNlFjaFkyQ0wzd1czVFZTaHM2NHpXai9GTlVRY0k3MDRieFhjRnNHV3pJcWxVZlVMdHdja2FUeFI4cGFLeVNoTEhCMEg1Uk5idWxWVk5UTVlMaU9Qa25EeTZucDJCWWFOQWJqZDRQbVVpeG9lZWVXSmNDQXdFQUFhT0I2VENCNWpBZkJnTlZIU01FR0RBV2dCVFBjSjFoNjUxOExyajN5d0pBOXdtZC9qTjBnREJJQmdOVkhTQUVRVEEvTUQwR0NHQ0JISWJ2S2dFQk1ERXdMd1lJS3dZQkJRVUhBZ0VXSTJoMGRIQTZMeTkzZDNjdVkyWmpZUzVqYjIwdVkyNHZkWE12ZFhNdE1UUXVhSFJ0TURnR0ExVWRId1F4TUM4d0xhQXJvQ21HSjJoMGRIQTZMeTkxWTNKc0xtTm1ZMkV1WTI5dExtTnVMMUpUUVM5amNtdzBNVGN5TG1OeWJEQUxCZ05WSFE4RUJBTUNBK2d3SFFZRFZSME9CQllFRkFUMmZIVENSdzkwa01uMGFUa2VCSUpua25JcU1CTUdBMVVkSlFRTU1Bb0dDQ3NHQVFVRkJ3TUNNQTBHQ1NxR1NJYjNEUUVCQlFVQUE0SUJBUUEwMjRLSWhSMHkxek91ZmZPcWRZMjYya3o5YkV1RUdjNXB4dGZYcFZhV0l6bkNpWmJTd0ZPNUwrMmhGTm5pbS9EMWpFL0ovUUxOczRudC9yS1R0eE50Zkg5YUc5aGs0RnB3TG9iVjNTSDJSQkV5aURhS3JuY2NCbTNuaVpYczQ4OU1BYkFnbE9uazR3MlZJa2FWM1k1c2k0UHg5R2E0UForZGNiZ1JuWDV0Q3h0Mk0yWG5xTG5lODVkVzZXRFVtektLUy9LcXVqOEQ1akpNQ0pwenVXRHQ0OGVMOUJJaTlaSUdQRkdOYnNqdnYwZlo3R3VCNGJiNVhhdnpmNVRsSG5QWlNwOUxGODh2VEpEc2NTZ3YxTDlCaDJCZ2NHUW96cjRRTWY0WjhkK0JNTWM2ckN3eTlqYVFHTC9rcmdSVHFEWTlIRitQMW53K3IxNTZ2eEVvdG82OE1ZSUJqRENDQVlnQ0FRRXdZVEJZTVFzd0NRWURWUVFHRXdKRFRqRXdNQzRHQTFVRUNoTW5RMmhwYm1FZ1JtbHVZVzVqYVdGc0lFTmxjblJwWm1sallYUnBiMjRnUVhWMGFHOXlhWFI1TVJjd0ZRWURWUVFERXc1RFJrTkJJRlJGVTFRZ1QwTkJNUUlGRUFKSk5SZ3dEUVlKWUlaSUFXVURCQUlCQlFBd0RRWUpLb1pJaHZjTkFRRUJCUUFFZ2dFQWsrVGhMRGRHNDBVc0k5SHJwaUpOWVJXZjAzbkUvQ21Cd1llcERmYlJ1N0E1SVRBNDd4aUM3RlNzSHgvVjA3SFBVUG1lU1BJZUVVTVB2TWVacjlocU9XQlNwR28zYjY4YVpjVEV5NEtOMk5RMEkwUlFYbFRKYksvbUJXUTdpcDJiUlhMZzl4M0tnSnpQRjNvR05seEJOUTB6ZmdxVFBHN0RUV292ZnpKSEplNTY0ekdiM08veWlSRkEzNG9hKzlCNG5jZFVteFBUaGN4Y1BjdjNqZFBNNXVQRzZvMDNkMkh2ZCtRSnFQbEEyQ0E5dnRqd2NXOE03ZVZ2Y3NVaFJyZGIxRWpkTWZDZUlrTWJaU2pySHc3eEJyQWNBbU91Zkp5c2lJUVo3MGRxT1p2bjMzNVlQakZWdndpNTd6ZUF1bmZVQ3NlS3RPeGhxbWN0dW40eEFEbGc1dz09';
// $result='a4ee55e33d2b3ddc95b97da1f79572ff916e4633872d7bee364548946bbc3107';
// $result='5b83ecb8a6d9493e7bad97dfde237c3f4311a351';
// $verify = verify($result);
// echo $verify;
// echo '<hr>';
// $a = urlencode("张三"); //等同于javascript encodeURI("电影");
// echo $a;
// $b = urldecode("checkValue=a4ee55e33d2b3ddc95b97da1f79572ff916e4633872d7bee364548946bbc3107&jsonData=%7B%22devsId%22%3A%2210210180009515128%22%2C%22legalName%22%3A%22%E5%BC%A0%E4%B8%89%22%2C%22extSeqId%22%3A%221561947128155%22%2C%22mobileMask%22%3A%221800000****%22%2C%22agentNo%22%3A%223100045000000084%22%2C%22agentName%22%3A%22%E4%BB%A3%E7%90%86%E5%95%86%E5%BC%80%E9%92%B1%E4%B8%89%22%2C%22activationTime%22%3A%2220180508142602%22%2C%22IdnoMask%22%3A%222106031998******21%22%2C%22userLevel%22%3A%2252%22%2C%22merchantName%22%3A%22%E7%BE%8E%E5%9B%BD%E8%BF%9B%E5%8F%A3%22%2C%22method%22%3A%22MemberActivation%22%2C%22merchantNo%22%3A%223100016000061735%22%7D"); //等同于javascript decodeURI("%E7%94%B5%E5%BD%B1");
// echo $b;
