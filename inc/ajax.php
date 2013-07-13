<?php
/*
 inc/ajax.php?state=
 定义一个操作
 1 => get_manger_depart
 2 => get_admin_wait_check_problem
 3 => get_admin_wait_accept_problem
 4 => get_admin_now_fixxing_problem
 */

session_start();
require("init.php");
require("JSON.php");
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
			case 2 :echo $json->encode(get_admin_wait_check_problem());break;
			case 3 :echo $json->encode(get_admin_wait_accept_problem());break;
			case 4 :echo $json->encode(get_admin_now_fixxing_problem());break;
		}
	}else if(strcmp($name,"depart") == 0){
		echo $json->encode(get_manger_block($code));
	}else if(strcmp($name,"nav_user") == 0){
		switch($code){
			case 1 :echo $json->encode(get_user_all_problem());break;
			case 2 :echo $json->encode(get_user_wait_pass_problem());break;
		}
	}
	

}
require_once("end.php");
?>
