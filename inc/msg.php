<?php

function sms($msgText,$phone){
    global $conn;
    $msgText = mysql_real_escape_string($msgText);
    $sql = "insert into `smg_catch` (`phone`,`content`) values('$phone', '$msgText')";
    return mysql_query($sql, $conn);
}

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
	sms($msgText,$phone);
}
function sendMSGToAdmin($proId, $msgText){
    $phone = getPhoneFromUser(6);
    sms($msgText,$phone);
}

function sendMSGToFix($proId, $FixId, $msgText){
    $phone = getPhoneFromUser($FixId);
    sms($msgText,$phone);
}

