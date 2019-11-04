<?php
$str = '题目是：指的是这样一个数列：1、1、2、3、5、8、13、21、34、……在数学上，斐波纳契数列以如下被以递推的方法定义：F(1)=1，F(2)=1, F(n)=F(n-1)+F(n-2)（n>=3，n∈N*）要你求第n项的数是多少？';
/**
 * 解法1
 */
echo $str.'<br>';
function getNumOne($n){
	if($n == 1 || $n == 2){
		return 1;
	}

	$res = getNumOne($n-1) + getNumOne($n-2);

	return $res;
}

echo getNumOne(5).'<br>';

/**
 * 解法2
 */

function getNumTwo($n, $meno = []){

	if(isset($meno[$n]) && $meno[$n] != -1) return $meno[$n];

	if($n <= 2){
		return 1;
	}else{
		$meno[$n] = getNumTwo($n-1, $meno) + getNumTwo($n-2, $meno);
	}

	return $meno[$n];
}

echo getNumTwo(10).'<br>';

/**
 * 解法三
 */

function getNumThree($n){
	if($n == 1) return 1;
	$memo = [0, 1];

	for($i=2; $i<=$n; $i++){
		$memo[$i] = $memo[$i-1] + $memo[$i-2];
	}
	echo '<pre>';
	var_dump($memo);
}

getNumThree(10);