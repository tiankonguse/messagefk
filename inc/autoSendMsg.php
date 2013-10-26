<?php
require_once("init.php");
require_once("function.php");
require_once("sms.php");
require_once("manger.fun.php");

checkAutoSendMsg();
//$filename = __FILE__;

//$f = fopen($filename, 'r');
//$locked = flock($f, LOCK_NB | LOCK_EX);
//if($locked) {
//    echo "unlock";
//	checkAutoSendMsg();
//	sleep(10);
//	flock($f, LOCK_UN);
//}else{
//	echo "lock";
//}
require_once('end.php');


?>
