<?php
$total = 100;
$size = 10;

echo '第一种方法 pageCount = (total%size == 0) ? total/size : (total/size)+1 <br>';
$pageCount = ($total%$size == '0') ? $total/$size : intval($total/$size)+1 ;
echo 'pageCount='.$pageCount.'<br>';
echo '<hr>';
echo '第二种 pageCount = intval((total + size -1)/pageSize)<br>';
$pageCount = intval(($total+$size-1)/$size);
echo 'pageCount='.$pageCount;