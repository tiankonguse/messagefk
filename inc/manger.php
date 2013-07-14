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
		if(!isset($_SESSION["messagefkLev"]) || $_SESSION["messagefkLev"]=="0"){
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
			case 3 :echo $json->encode(add_depart());break;
			case 4 :echo $json->encode(update_depart());break;
			case 5 :echo $json->encode(delete_depart());break;
			case 6 :echo $json->encode(add_block());break;
			case 7 :echo $json->encode(update_block());break;
			case 8 :echo $json->encode(delete_block());break;
			case 9 :echo $json->encode(get_depart_block());break;
			case 10:echo $json->encode(add_question());break;
			case 11:echo $json->encode(update_depart_admin());break;
			case 12:echo $json->encode(delete_depart_admin());break;
			case 13:echo $json->encode(passCheck());break;
		}
	}
}
require_once("end.php");
?>
