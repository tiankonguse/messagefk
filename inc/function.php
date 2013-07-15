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
	return $lev == $messagefkLev;
}

$stateArray = Array("审核未通过","等待审核","等待受理","维修中“，等待评价","问题完成");

function getStateHtml($state){
	global  $stateArray;
	$state = intval($state);
	return $stateArray[$state % PRO_NOT_PASS];
}


function deleteMapDepart($departId) {
	global $conn;	
	$sql = "DELETE FROM `map_block_depart` WHERE `depart_id` = '$departId'";
	return mysql_query($sql, $conn);
}

function deleteMapBlock($blockId) {
	global $conn;
	$sql = "DELETE FROM `map_block_depart` WHERE `block_id` = '$blockId'";
	$result1 = mysql_query($sql, $conn);
	
	$sql = "DELETE FROM `block` WHERE `id` = '$blockId' ";
	$result2 = mysql_query($sql, $conn);
	return $result2 && $result1;
}

function deleteMapDepartBlock($departId, $blockId) {
	global $conn;
	$sql = "DELETE FROM `map_block_depart` WHERE `block_id` = '$blockId' and `depart_id` = '$departId'";
	return mysql_query($sql, $conn);
}

function addMapDepartBlock($departId, $blockId) {
	global $conn;
	$sql = "INSERT INTO `map_block_depart`(`block_id`, `depart_id`) VALUES ('$blockId','$departId')";
	return mysql_query($sql, $conn);
}

function addProblemTime($proId, $userId, $time, $state) {
	global $conn;
	$sql = "INSERT INTO `problem_time`(`pro_id`, `user_id`, `time`, `state`) VALUES ('$proId', '$userId', '$time', '$state')";
	mysql_query($sql, $conn);
}

function _deleteDepartAdmin($departId){
	global $conn;
	
	$sql = "select * from `depart` where `id` = '$departId'";
	$result = mysql_query($sql, $conn);
	if(!$row = mysql_fetch_array($result)){
		return false;
	}
	
	$userId = $row["center"];

	$sql = "select count(*) num from `depart` where `center` = '$userId'";;
	$result = mysql_query($sql, $conn);
	$row = mysql_fetch_array($result);
	$num = $row["num"];

	if($num == 0){
		return true;
	}

	if($num == 1){
		if(!mysql_query("UPDATE `user` SET `lev` = '1'  WHERE `id`= $userId", $conn)){
			return false;
		}
	}

	if(mysql_query("UPDATE `depart` SET `center` = NULL WHERE `id`= $departId", $conn)){
		return true;
	}else{
		return false;
	}
}

function isExistMapDepartBlock($departId, $blockId){
	global $conn;
	$sql = "select count(*) num  from `map_block_depart` where  depart_id = '$departId' and  block_id = '$blockId' ";
	$result = mysql_query($sql, $conn);
	$row = mysql_fetch_array($result);
	return $row["num"];
}


function getCenterId($departId){
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
