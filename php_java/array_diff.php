<?php
	$all = [1,2,3,4,7,9];
	$local = [1,6,7,8,9];
	$diff = array_diff($all, $local);
	$di = array_diff($local, $all);
	echo '<pre>';
	var_dump($diff,$di);die;