<?php
/*
 inc/manger.php?id=
 定义一个操作
 register      => 1
 login         => 2
 add_depart    => 3
 update_depart => 4
 delete_depart => 5
 add_block     => 6
 update_block  => 7
 delete_block  => 8
 get_depart_block => 9
 add_question => 10
 update_depart_admin => 11
 delete_depart_admin => 12
 passCheck       => 13
 NotPassCheck => 14
 accept  => 15
 finish => 16
 over => 17
 everyYearNumberOfRepairs => 18
 */
session_start();
require_once("init.php");
require_once("JSON.php");
$json = new Services_JSON();
require_once("msg.php");
require_once("function.php");
require_once("manger.fun.php");


if((!$conn || !$result) && $ret){
	// db error
	echo $json->encode($ret);
}else if(!isset($_GET["state"])){
	//url error
	$ret = output(14,"非法操作");
	echo $json->encode($ret);
}else{

	$code = $_GET["state"];
	if($code != 1 && $code != 2){
		// check whether have permission
		if(!isset($_SESSION["messagefkLev"]) || $_SESSION["messagefkLev"] == 0){
			$ret = output(9,"请先登录在操作");
		}
	}

	if($ret){
		// no permission
		echo $json->encode($ret);
	}else{
		// have permission
		switch($code){
			case 1 :echo $json->encode(register());break;
			case 2 :echo $json->encode(login());break;
			case 3 :echo $json->encode(addDepart());break;
			case 4 :echo $json->encode(updateDepart());break;
			case 5 :echo $json->encode(deleteDepart());break;
			case 6 :echo $json->encode(addBlock());break;
			case 7 :echo $json->encode(updateBlock());break;
			case 8 :echo $json->encode(deleteBlock());break;
			case 9 :echo $json->encode(getDepartBlock());break;
			case 10:echo $json->encode(addProblem());break;
			case 11:echo $json->encode(updateDepartAdmin());break;
			case 12:echo $json->encode(deleteDepartAdmin());break;
			case 13:echo $json->encode(passCheck());break;
			case 14:echo $json->encode(notPassCheck());break;
			case 15:echo $json->encode(accept());break;
			case 16:echo $json->encode(finish());break;
			case 17:echo $json->encode(over());break;
			case 18:echo $json->encode(everyYearNumberOfRepairs());break;
		}
	}
}
require_once("end.php");
?>
