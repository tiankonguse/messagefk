<?php
	
	include"sms.php";

	$msg="老师您好，袁小康于09月23日17时54分";
	$phone_num="13944097701";
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
