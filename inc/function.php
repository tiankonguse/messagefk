<?php

function isEmail($email){
	return preg_match('/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/', $email);
}

function isPhone($phone){
	return preg_match('/^[0-9]{11,11}$/', $phone);
}


function isExistUser($email){
	global $conn;
	
	if(!isEmail($email))return false;
	
	$sql = "select * from user where email = '$email'";
	$resultUser = mysql_query($sql, $conn);
	if (!($row = mysql_fetch_array($resultUser))) {
		return false;
	}else{
		return true;
	}
}

function addUser($email, $lev) {

	global $conn;
	$lev = intval($lev);
	if($lev == 0)return false;
	if(!isEmail($email))return false;

	$sql = "insert into `user` (`email`,`lev`) values('$email', '$lev')";
	return mysql_query($sql, $conn);
}


function getUserId($email) {
//$email should be security and correct.

	global $conn;
	$sql = "select * from user where email = '$email'";
	$resultUser = mysql_query($sql, $conn);

	if (!($row = mysql_fetch_array($resultUser))) {
		//first add user
		if(!addUser($email, "1")) return 0;
		$sql = "select * from user where email = '$email'";
		$resultUser = mysql_query($sql, $conn);
		$row = mysql_fetch_array($resultUser);
	}
	return $row['id'];
}

function setUserLev($userId, $lev, $phone) {
	global $conn;
	
	$userId = intval($userId);
	$lev = intval($lev);
	$phone = intval($phone);
	
	if($userId == 0 || $lev == 0 || !(isPhone($phone))){
		return false;
	}
	
	$sql = "UPDATE `user` SET `lev` = '$lev' ,`phone` = '$phone' WHERE `id`= $userId";
	return mysql_query($sql, $conn);
}

function getDepartName($departId){
	global $conn;
	$departId = intval($departId);
	$sql = "select * from `depart` where `id` = '$departId'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['name'];
	}else{
		return "";
	}

}

function getDepartMangerId($departId){
	global $conn;
	$departId = intval($departId);
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
	$blockId = intval($blockId);
	$sql = "select * from `block` where `id` = '$blockId'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['name'];
	}else{
		return "";
	}
}


function getStateTime($problemId, $state){
	global $conn;
	$problemId = intval($problemId);
	$state = intval($state);	
	
	$sql = "select * from `problem_time` where `pro_id` = '$problemId' and `state` = '$state'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['time'];
	}else{
		return "";
	}
}

function getUserEmail($userId){
	global $conn;
	$userId = intval($userId);
	
	$sql = "select * from `user` where `id` = '$userId'";
	$result = mysql_query($sql ,$conn);
	if($row = mysql_fetch_array($result)){
		return $row['email'];
	}else{
		return "";
	}
}

function checkLev($lev){
	$messagefkLev   = intval($_SESSION['messagefkLev']);
	$lev = intval($lev);
	return strcmp($lev,$messagefkLev);
}

$stateArray = Array("审核未通过","等待审核","等待受理","维修中","问题解决，等待评价","问题完成");

function getStateHtml($state){
	global  $stateArray;
	$state = intval($state);
	return $stateArray[$state%7];
}
