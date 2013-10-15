<?php

include "php_serial.class.php";

$serial = false;
$set = false;
$open = false;

function sms($msg,$phone_num){
	global $serial;
	global $set;
	global $open;
	
	if($serial === false){
		$serial = new phpSerial;
	}
	 
	$phone_num = "86".$phone_num;
	//加载php操作串口的类
	$flag=false;

	//给ttyUSB0 赋权限
	// exec("chmod 775 /dev/ttyUSB0",$output,$status);
	 
	//连接USB gas modem
	if(!$set){
		if($serial->deviceSet("/dev/ttyUSB0")){
			$flag=true;
			$set = true;
		}else{
			return false;
		}

	}

	if(!$open){
		if($serial->deviceOpen()){
			$flag=true;
			$open = true;
		}else{
			return false;
		}
	}


	//要发送的手机号:
	$phone_sendto = InvertNumbers($phone_num);

	//$msg='I am yums,i love 中国';
	//echo $msg;

	$message = hex2str($msg);
	//echo strlen($message);
	$mess = "11000D91".$phone_sendto."000800".sprintf("%02X",strlen($message)/2).$message;

	$serial->sendMessage("at+cmgf=0".chr(13));

	$serial->sendMessage("at+cmgs=".sprintf("%d",strlen($mess)/2).chr(13));
	//不加短信中心号码
	$serial->sendMessage('00'.$mess.chr(26));

	return $flag;
}

//将utf8的短信转成ucs2格式
function hex2str($str) {
	$hexstring=iconv("UTF-8", "UCS-2", $str);
	//   echo strlen($hexstring);
	$str = '';
	for($i=0; $i<strlen($hexstring)/2; $i++){
		$str .= sprintf("%02X",ord(substr($hexstring,$i*2+1,1)));
		$str .= sprintf("%02X",ord(substr($hexstring,$i*2,1)));
	}
	return $str;
}

//手机号翻转,pdu格式要求
function InvertNumbers($msisdn) {
	$len = strlen($msisdn);
	if ( 0 != fmod($len, 2) ) {
		$msisdn .= "F";
		$len = $len + 1;
	}

	for ($i=0; $i<$len; $i+=2) {
		$t = $msisdn[$i];
		$msisdn[$i] = $msisdn[$i+1];
		$msisdn[$i+1] = $t;
	}
	return $msisdn;
}
?>
