<?php
	$arr[] = $num = '01';
	$strLength = strlen($num);
	for($i=0;$i<100;$i++){
		$newNum = end($arr) + 1;
		$arr[] = str_pad($newNum, $strLength, '0', STR_PAD_LEFT);
	}
	echo '<pre>';
	var_dump($arr);die;