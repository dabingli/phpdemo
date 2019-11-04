<?php
echo time();
echo '<hr>';
function getMillisecond() {
	list($s1, $s2) = explode(' ', microtime());
	var_dump((floatval($s1) + floatval($s2)));
	return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
}
echo getMillisecond();