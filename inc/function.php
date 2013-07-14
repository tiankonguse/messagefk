<?php
function getDepartName($depart_id){
	global $conn;
	$sql = "select * from `depart` where `id` = '$depart_id'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['name'];
	}else{
		return "";
	}

}

function getDepartMangerId($departId){
	global $conn;
	$sql = "select * from `depart` where `id` = '$departId'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['center'];
	}else{
		return "0";
	}

}


function getBlocktName($blockId){
	global $conn;
	$sql = "select * from `block` where `id` = '$blockId'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['name'];
	}else{
		return "";
	}
}


function getStateTime($pro_id, $state){
	global $conn;
	$sql = "select * from `problem_time` where `pro_id` = '$pro_id' and `state` = '$state'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['time'];
	}else{
		return "";
	}
}

function getUserEmail($user_id){
	global $conn;
	$sql = "select * from `user` where `id` = '$user_id'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['email'];
	}else{
		return "";
	}
}

function checkLev($lev){
	$messagefk_lev   = intval($_SESSION['messagefk_lev']);
	return strcmp($lev,$messagefk_lev);
}

$stateArray = Array("审核未通过","等待审核","等待受理","维修中","问题解决，等待评价","问题完成");

function getStateHtml($state){
	global  $stateArray;
	return $stateArray[$state%7];
}
