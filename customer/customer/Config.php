<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2018/7/24
 * Time: 12:47
 */


class Config
{
    public static $baseHost = "wsk.api.test.91yong.vip/customer/save-user";
    // public static $baseHost = "www.csshenka.com/app/web/customer/save-user";
    public static $oemID = '64329ecef1b297e47d92a1fbd8070884';
    public static $code = 'kaidianbao';
    public static $merchant = "13005709476";
    public static $publicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC+Q/KwuCeRGUHS02mYAWiWc8ixLwCxDFJehFHi+ccitnFaT7/7+NIr23mfbgq3k8jSs+OwYbNT2JdZSVgy+te35oXnD4vLb8xYQIU/va6jOlYvnnX3ZUTyqJI6rK7YgmtkdNWszjqIeiVc+0p7na34ZpYZLSaoFCWcZoaQaLRMYwIDAQAB";

    public static $privateKey = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAL5D8rC4J5EZQdLTaZgBaJZzyLEvALEMUl6EUeL5xyK2cVpPv/v40ivbeZ9uCreTyNKz47Bhs1PYl1lJWDL617fmhecPi8tvzFhAhT+9rqM6Vi+edfdlRPKokjqsrtiCa2R01azOOoh6JVz7SnudrfhmlhktJqgUJZxmhpBotExjAgMBAAECgYEAvj1CU+BN747JeftZAVunL4fliwPsNRqU4Vx8Y+5LZjH1dM94roBD5QY1vWtR2+wwSD0F1D5cB+Hwsp3bSl31gXnfg8JevKLs0hAM6DCDVYoC+PNZs2pVSpHYQ9mw9SFbhKH6KTtaqK2cjB5W2nIKm22x2pkFU4V1WNZtRoplR8ECQQDgKpknFMWiT9JtingALiSM52r5XSS72DoBsqGG+RM/XOnnpUyZ5SykcBQAsjTwUzbFKKF+f2ShyacU+GGgVMI9AkEA2Ujns2LeKpX5obpFfALss4ZybDRkwfTIADeOM2lkDbQpvSsU1HZ41lgUVhApo41lvkEWALnnfLNpwWuQu8NTHwJAN6y8zwUMtOxoUgaDGWBceZZ8biShG/pvJb7M+W3hRup3ua3HYa2WsdyYSzf3h/zS7JLT0UwonTotQjsSXDTQ7QJBALZWK7mpee4atMU23yBWA/QTGuoafYMVutATzszt3/xv96a7BFvWn0if2VDvd0G8YmjpjWFGoC9RD6o0bdxi6NkCQHgCZi1xqauRj2cQEU+d1Qwf/6Cfx76RjCw3DbDTDujhi6hajImOcPZdbQJeSbLJPIHm6zcb93Beb9+1aqHqbis=";

    static function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

    static function convertPublicKey($publicKey) {
        //判断是否传入公钥内容
        $public_key_string = !empty($publicKey) ? $publicKey : '';
        //64位换行公钥钥内容
        $public_key_string = chunk_split($public_key_string, 64, "\r\n");
        //公钥头部
        $public_key_header = "-----BEGIN PUBLIC KEY-----\r\n";
        //公钥尾部
        $public_key_footer = "-----END PUBLIC KEY-----";
        //完整公钥拼接
        $public_key_string = $public_key_header.$public_key_string.$public_key_footer;
        return $public_key_string;
    }

    static function convertPrivateKey($privateKey) {
        //判断是否传入私钥内容
        $public_key_string = !empty($privateKey) ? $privateKey : '';
        //64位换行公钥钥内容
        $public_key_string = chunk_split($public_key_string, 64, "\r\n");
        //私钥头部
        $public_key_header = "-----BEGIN RSA PRIVATE KEY-----\r\n";
        //私钥尾部
        $public_key_footer = "-----END RSA PRIVATE KEY-----";
        //完整私钥拼接
        $public_key_string = $public_key_header.$public_key_string.$public_key_footer;
        return $public_key_string;
    }
}