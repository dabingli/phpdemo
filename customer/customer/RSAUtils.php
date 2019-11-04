<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2018/7/24
 * Time: 12:43
 */

class RSAUtils
{

    private $pubKey = null;
    private $priKey = null;

    /**
     * 构造函数
     *
     * @param string 公钥文件（验签和加密时传入）
     * @param string 私钥文件（签名和解密时传入）
     */
    public function __construct($public_key = '', $private_key = '')
    {
        if ($public_key) {
            $this->pubKey = openssl_pkey_get_public($public_key);
        }
        if ($private_key) {
            $this->priKey = openssl_pkey_get_private($private_key);
        }

//        print_r($public_key);
//        print_r("\n");
//        print_r($private_key);
//        print_r("\n");
    }

    /**
     * 功能： 签名
     * author:
     * $args 签名字符串数组
     * return 签名结果
     */
    public function rsaSign($args)
    {
        $args = self::arrayFilter($args);
        ksort($args);
        $query = '';
        foreach ($args as $k => $v) {
            if ($k == 'SignType') {
                continue;
            }
            if ($query) {
                $query .= '&' . $k . '=' . $v;
            } else {
                $query = $k . '=' . $v;
            }
        }
        $pkeyid = openssl_get_privatekey($this->priKey);
        openssl_sign($query, $sign, $pkeyid);
        openssl_free_key($pkeyid);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 过滤一些空值
     *
     * @param unknown $args            
     * @return unknown
     */
    static public function arrayFilter($args)
    {
        // $args = array_filter($args); // 能将值为0的过滤
        foreach ($args as $k => $val) {
            if ($val === '' || $val === null) {
                unset($args[$k]);
            }
        }
        return $args;
    }

    /**
     * 功能： 验证签名
     *
     * @param $args 需要签名的数组            
     * @param $sign 签名结果
     *            return 验证是否成功
     */
    public static function rsaVerify($args, $sign)
    {
        $args = self::arrayFilter($args);

        ksort($args);
        $query = '';
        foreach ($args as $k => $v) {
            if ($k == 'sign_type' || $k == 'sign') {
                continue;
            }
            if ($query) {
                $query .= '&' . $k . '=' . $v;
            } else {
                $query = $k . '=' . $v;
            }
        }
        // 这地方不能用 http_build_query 否则会urlencode
        $sign = base64_decode($sign);
        $pkeyid = openssl_get_publickey($this->pubKey);
        if ($pkeyid) {
            $verify = openssl_verify($query, $sign, $pkeyid);
            openssl_free_key($pkeyid);
        }
        if ($verify == 1) {
            return true;
        } else {
            return false;
        }
    }
}