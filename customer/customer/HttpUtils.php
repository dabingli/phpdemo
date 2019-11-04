<?php
/**
 * Created by PhpStorm.
 * User: Adi
 * Date: 2018/6/20
 * Time: 15:36
 */


function post($url, $headers, $params)
{
    $data = json_encode($params);

    $curl = curl_init();

    array_push($headers, "Content-Type: application/json");
    array_push($headers, "Content-Length: " . strlen($data));

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function form($url, $headers, $params)
{
    $data = "";
    foreach ($params as $k => $v) {
        $data .= "$k=" . urlencode($v) . "&";
    }
    $data = substr($data, 0, -1);

    $curl = curl_init();

    array_push($headers, "Content-Type: application/x-www-form-urlencoded");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

    print_r("=========请求信息 start =========\n");
    print_r($url . "\n");
    print_r(json_encode($headers) . "\n");
    print_r($data  . "\n");
    $response = curl_exec($curl);
    curl_close($curl);
    print_r("==============================\n");
    print_r($response);
    print_r("\n=========请求信息 end =========\n");
    return $response;
}

function get($url, $headers)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    return $response;
}

function form_file($url, $headers, $params)
{
    $curl = curl_init();
    if (class_exists('\CURLFile')) {
        curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
    } else {
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
        }
    }

    array_push($headers, "Content-Type: multipart/form-data");
    // array_push($headers, "Content-Type: application/x-www-form-urlencoded");


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

    print_r("=========请求信息 start =========\n");
    print_r($url . "\n");
    print_r(json_encode($headers) . "\n");
    print_r($params  . "\n");
    $response = curl_exec($curl);
    curl_close($curl);
    print_r("==============================\n");
    print_r($response);
    print_r("\n=========请求信息 end =========\n");
    return $response;
}