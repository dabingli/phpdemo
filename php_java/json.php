<?php
$arr = [
	'1'=>['name'=>'江苏','children'=>['101'=>['name'=>'南京'],'102'=>['name'=>'常州']]],
	'2'=>['name'=>'河南','children'=>['201'=>['name'=>'南阳'],'202'=>['name'=>'安阳']]],
];
var_dump(json_encode($arr));