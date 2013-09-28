<?php 
$first = time();
echo date("m月d日H时i分s秒",$first)."<br/>";
echo $first."<br/>";
sleep(3);
echo "</br>";
$second = time();
echo date("m月d日H时i分s秒",$second)."<br/>";
echo $second."<br/>";
echo "</br>";

echo ($second - $first)."<br/>";

echo intval(($second - $first)/60);

?>