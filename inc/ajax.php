<?php
/*
 inc/ajax.php?state=
 定义一个操作
 1 => manger_depart.php
 */

session_start();
require_once("init.php");
require_once("JSON.php");
$json = new Services_JSON();
require_once("ajax.fun.php");

if((!$conn || !$result) && $ret){
	// db error
	echo $json->encode($ret);
}else if(!isset($_POST["state"]) || !isset($_POST["name"])){
	//url error
	$ret = output(14,"非法操作");
	echo $json->encode($ret);
}else{
	$code = $_POST["state"];
	$name = $_POST["name"];
	
	if(strcmp($name,"nav_admin") == 0){
		switch($code){
			case 1 :echo $json->encode(get_manger_depart());break;
		}
	}else if(strcmp($name,"depart") == 0){
		echo $json->encode(get_manger_block($code));
	}
	

}
require_once("end.php");
?>