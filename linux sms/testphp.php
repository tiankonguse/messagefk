<?php
	
	include"sms.php";

	$msg="我是于茂升，我在测试一个东西，如果您收到短信，请QQ回复我哦。谢谢啦";
	$phone_num="8618943696702";
//	if(sms($msg,$phone_num);

	if(sms($msg,$phone_num)){
		echo "success";
	}else{
		echo "failed";	
	}

	/*
 	exec("sudo chmod 775 /dev/ttyUSB0",$output,$status);
	print_r($output);
        echo $status;
	*/
?>
