<?php
include "sms.php";

function getPhoneFromPro($proId){
    global $conn;
    $sql = "SELECT `phone` FROM `problem` WHERE `id` = '$proId'";
    $result = mysql_query($sql, $conn);
    $row = mysql_fetch_array($result);
    $phone = $row['phone'];
    return $phone;
}
function getPhoneFromUser($userId){
    global $conn;
    $sql = "SELECT `phone` FROM `user` WHERE `id` = '$userId'";
    $result = mysql_query($sql, $conn);
    $row = mysql_fetch_array($result);
    $phone = $row['phone'];
    return $phone;
}

function sendMSGToUser($proId, $userId, $msgText){
	$phone = getPhoneFromPro($proId);
    try{
        sms($msgText,$phone);
    }catch(Exception $e){
    
    }
}
function sendMSGToAdmin($proId, $msgText){
    $phone = getPhoneFromUser($proId);
    try{
    	sms($msgText,$phone);
    }catch(Exception $e){
    
    }
    
}

function sendMSGToFix($proId, $FixId, $msgText){
    $phone = getPhoneFromUser($proId);
    try{
        sms($msgText,$phone);
    }catch(Exception $e){
    
    }
}

