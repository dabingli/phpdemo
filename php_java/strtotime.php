<?php
var_dump(date('Y-m-d', strtotime('-1 month', strtotime('2019-3-11'))));
echo '<hr>';
$days = 7;
for($i=$days-1;$i>=0;$i--){
    $times[] = [
        'createdAtStart' => date('Y-m-d 00:00:00', strtotime('-'.$i.'days')),
        'createdAtEnd' => date('Y-m-d 23:59:59', strtotime('-'.$i.'days')),
    ];
}
// for($i=6;$i>0;$i--){
// 	echo $i.'<br>';
// }
echo '<pre>';
// var_dump($times);
