<?php
	$img = 'http://dian-pos.oss-cn-shenzhen.aliyuncs.com/images/2019/07/04/image_156222062210154515.jpg';
	function curl_url($url,$timeout=30){
        $dir= pathinfo($url);
        $host = $dir['dirname'];
        $refer= $host.'/';
        $ch = curl_init($url);
        curl_setopt ($ch, CURLOPT_REFERER, $refer); //伪造来源地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回变量内容还是直接输出字符串,0输出,1返回内容
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);//在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出
        curl_setopt($ch, CURLOPT_HEADER, 0); //是否输出HEADER头信息 0否1是
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); //超时时间
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $httpContentType = $info['content_type'];
        curl_close($ch);

        $base_64 = 'data:' . $httpContentType . ';base64,' . chunk_split(base64_encode($data));
        return $base_64;
    }

	echo curl_url($img);
