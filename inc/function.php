<?php
	function getDepartName($depart_id){
		global $conn;
		$sql = "select * from `depart` where `id` = '$depart_id'";
		$result = mysql_query($sql ,$conn);
		$row = mysql_fetch_array($result);
		return $row['name'];
	}
	
	function getStateTime($pro_id, $state){
		global $conn;
		$sql = "select * from `problem_time` where `pro_id` = '$pro_id' and `state` = '$state'";
		$result = mysql_query($sql ,$conn);
		$row = mysql_fetch_array($result);
		return $row['time'];
	}
	
	function getUserEmail($user_id){
		global $conn;
		$sql = "select * from `user` where `id` = '$user_id'";
		$result = mysql_query($sql ,$conn);
		$row = mysql_fetch_array($result);
		return $row['email'];
	}