<?php
session_start();
require("init.php");
require("JSON.php");
$json = new Services_JSON();
require("function.php");
require("ajax.fun.php");

if((!$conn || !$result) && $ret){
	// db error
	echo $json->encode($ret);
}else if(!isset($_POST["state"]) || !isset($_POST["name"])){
	//url error
	$ret = output(14,"非法操作");
	echo $json->encode($ret);
}else{
	$code = $_POST["state"];
	$name = $_POST["name"];

	if(strcmp($name,"nav_admin") == 0){
		switch($code){
			case 1 :echo $json->encode(getMangerDepart());break;
			case 2 :echo $json->encode(getAdminWaitCheckProblem());break;
			case 3 :echo $json->encode(getAdminWaitAcceptProblem());break;
			case 4 :echo $json->encode(getAdminNowFixxingProblem());break;
			case 5 :echo $json->encode(getAdminWaitEvaluateProblem());break;
			case 6 :echo $json->encode(getAdminFinishProblem());break;
			case 7 :echo $json->encode(getAdminNotPassProblem());break;
		}
	}else if(strcmp($name,"depart") == 0){
		echo $json->encode(getMangerBlock($code));
	}else if(strcmp($name,"nav_user") == 0){
		switch($code){
			case 1 :echo $json->encode(getUserAllProblem());break;
			case 2 :echo $json->encode(getUserWaitCheckProblem());break;
			case 3 :echo $json->encode(getUserWaitAcceptProblem());break;
			case 4 :echo $json->encode(getUserNowFixingProblem());break;
			case 5 :echo $json->encode(getUserWaitEvaluateProblem());break;
			case 6 :echo $json->encode(getUserFinishProblem());break;
		}
	}else if(strcmp($name, "nav_index")== 0){
		switch($code){
			case 1 :echo $json->encode(getIndexAllProblem());break;
			case 2 :echo $json->encode(getIndexWaitAcceptProblem());break;
			case 3 :echo $json->encode(getIndexNowFixingProblem());break;
			case 4 :echo $json->encode(getIndexWaitEvaluateProblem());break;
			case 5 :echo $json->encode(getIndexFinishProblem());break;
		}
	}else if(strcmp($name, "nav_fix") == 0){
		switch($code){
			case 1 :echo $json->encode(getFixAllProblem());break;
			case 2 :echo $json->encode(getFixWaitAcceptProblem());break;
			case 3 :echo $json->encode(getFixNowFixingProblem());break;
		}
	}


}
require_once("end.php");
?>
