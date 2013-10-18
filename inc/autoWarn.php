<?php
require_once("init.php");
require_once("msg.php");
require_once("function.php");
require_once("manger.fun.php");
$filename = __FILE__;

$f = fopen($filename, 'r');
$locked = flock($f, LOCK_NB | LOCK_EX);
if($locked) {
    checkAutoWarn();
    flock($f, LOCK_UN);
}
require_once('end.php');