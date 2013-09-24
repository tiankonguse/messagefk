<?php

function register() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['email']) && isset ($_POST['password1']) && isset ($_POST['password2'])) {
		//获得表单数据
		$email = $_POST['email'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		//检查表单数据是否合法
		if (strcmp($email, "") == 0 || strcmp($password1, "") == 0 || strcmp($password2, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		if (strcmp($password1, $password2) != 0) {
			return output(OUTPUT_ERROR, "输入的两次密码不同");
		}

		if (!isEmail($email)) {
			return output(OUTPUT_ERROR, "邮箱格式不正确");
		}

		//防止sql注入
		$email = mysql_real_escape_string($email);
		$password = sha1(SALT . $password1);

		//实现此函数功能前检查此操作是否合法
		if (isExistUser($email)) {
			return output(OUTPUT_ERROR, "该邮箱已存在");
		}

		//实现本函数功能
		if(addUser($email,LEV_USER)){
			$_SESSION['email'] = $email;
			$_SESSION['lev'] = LEV_USER;
			return output(OUTPUT_SUCCESS, "注册成功");
		}else{
			return output(OUTPUT_ERROR, "新用户添加失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function login() {
	global $conn;
	if (isset ($_POST['email']) && isset ($_POST['password'])) {
		//获得表单数据
		$email = $_POST['email'];
		$password = $_POST['password'];

		//检查表单数据是否合法
		if (strcmp($email, "") == 0 || strcmp($password, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		if (!isEmail($email)) {
			return output(OUTPUT_ERROR, "邮箱格式不正确");
		}

		//防止sql注入
		$email = mysql_real_escape_string($email);
		$password = sha1(SALT . $password);

		//操作数据库
		$sql = "select * from user where email = '$email'";
		$result = @ mysql_query($sql, $conn);
		if ($result && $row = mysql_fetch_array($result)) {
			$_SESSION['messagefkId'] = $row['id'];
			$_SESSION['messagefkEmail'] = $row['email'];
			$_SESSION['messagefkLev'] = $row['lev'];
			return output(OUTPUT_SUCCESS, "登录成功");
		} else {
			return output(OUTPUT_ERROR, "用户名或密码错误");
		}

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function addDepart() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['name'])) {
		//获得变量的数据
		$name = $_POST['name'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);

		//实现此函数功能前检查此操作是否合法
		$sql = "select * from `depart` where name = '$name'";
		$result = @ mysql_query($sql, $conn);
		if ($result && mysql_num_rows($result) > 0) {
			return output(OUTPUT_ERROR, "该分类已存在");
		}

		//实现本函数功能
		$sql = "insert into `depart` (`name`) values('$name')";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(OUTPUT_SUCCESS, "分类添加成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function updateDepart() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['name']) && isset ($_POST['id'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($id, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$id = mysql_real_escape_string($id);

		//实现本函数功能
		$sql = "UPDATE `depart` SET `name`='$name' WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(OUTPUT_SUCCESS, "分类名称更改成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function deleteDepart() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$id = mysql_real_escape_string($id);

		if(!_deleteDepartAdmin($id)){
			return output(OUTPUT_ERROR, "管理员删除失败");
		}

		if(!deleteMapDepart($id)){
			return output(OUTPUT_ERROR, "删除小分类时出错");
		}


		//实现本函数功能
		$sql = "DELETE FROM `depart` WHERE `id` = '$id'";
		$result = mysql_query($sql, $conn);
		if ($result) {
			return output(OUTPUT_SUCCESS, "分类删除成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function addBlock() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['name']) || isset ($_POST['name'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$departId = $_POST['depart_id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($departId, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$departId = mysql_real_escape_string($departId);

		//实现此函数功能前检查此操作是否合法
		$sql = "select * from `block` where name = '$name'";
		$result = mysql_query($sql, $conn);
		if ($result && mysql_num_rows($result) > 0) {
			$row = mysql_fetch_array($result);
			$blockId = $row["id"];
			if(isExistMapDepartBlock($departId,$blockId)){
				return output(OUTPUT_ERROR, "这个子分类已经存在");
			}
		}else{
			//插入子分类
			$sql = "insert into `block` (`name`) values('$name')";
			$result = mysql_query($sql, $conn);

			//得到子分类的id
			$sql = "SELECT `id` FROM `block` WHERE name = '$name'";
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_array($result);
			$blockId = $row['id'];
		}

		//建立大分类与子分类的联系
		$result = addMapDepartBlock($departId, $blockId);

		if ($result) {
			return output(OUTPUT_SUCCESS, "子分类添加成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function updateBlock() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['name']) && isset ($_POST['id'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($id, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$id = mysql_real_escape_string($id);

		//实现本函数功能
		$sql = "UPDATE `block` SET `name`='$name' WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(OUTPUT_SUCCESS, "子分类名称更改成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function deleteBlock() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//防止sql注入
		$id = mysql_real_escape_string($id);

		deleteMapBlock($id);

		//实现本函数功能
		$sql = "DELETE FROM `block` WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(OUTPUT_SUCCESS, "子分类删除成功");
		} else {
			return output(OUTPUT_ERROR, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function getDepartBlock() {
	global $conn;

	if(checkLev(LEV_VISITOR)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	$sql = "select * from depart where center != ''";
	$result_depart = mysql_query($sql, $conn);

	$ret = array ();

	while ($row_depart = mysql_fetch_array($result_depart)) {

		$depart["" . $row_depart['id'] . ""] = $row_depart['name'];

		$depart = array ();
		$block = "<option value='0'>请选择类型</option>\n";

		$sql = "SELECT * FROM `block` WHERE id in (SELECT `block_id` FROM `map_block_depart` WHERE depart_id = '" . $row_depart['id'] . "')";
		$result_block = mysql_query($sql, $conn);
		while ($row_block = mysql_fetch_array($result_block)) {
			$block .= "<option value='" . $row_block['id'] . "'>" . $row_block['name'] . "</option>\n";
		}

		$ret["" . $row_depart['id'] . ""] = array (
			"depart_id" => $row_depart['id'],
			"name" => $row_depart['name'],
			"block" => $block
		);

	}
	return $ret;
}

function addProblem() {
	global $conn;

	/*
	 title:$title,
	 depart_id:$depart_id,
	 block_id:$block_id,
	 name:$name,
	 phone:$phone,
	 content:$content
	 */

	// check whether the post is legitimate
	if (isset ($_POST['title']) && isset ($_POST['depart_id']) && isset ($_POST['block_id']) && isset ($_POST['name']) && isset ($_POST['email']) && isset ($_POST['phone']) && isset ($_POST['content'])) {
		//get the post
		$title = $_POST['title'];
		$depart_id = $_POST['depart_id'];
		$block_id = $_POST['block_id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$content = $_POST['content'];

		//check whether the data is null
		if (strcmp($title, "") == 0 || strcmp($depart_id, "") == 0 || strcmp($block_id, "") == 0 || strcmp($name, "") == 0 || strcmp($email, "") == 0 || strcmp($phone, "") == 0 || strcmp($content, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		if (!preg_match('/^[0-9]{11,11}$/', $phone)) {
			return output(OUTPUT_ERROR, "电话号码不正确");
		}

		if (!preg_match('/^.+?@.+?\..+?$/', $email)) {
			return output(OUTPUT_ERROR, "邮箱格式不正确");
		}


		//prevent xss
		$title = xss($title);
		$name = xss($name);
		$content = xss($content);

		//Prevent sql injection
		$title = mysql_real_escape_string($title);
		$depart_id = mysql_real_escape_string($depart_id);
		$block_id = mysql_real_escape_string($block_id);
		$name = mysql_real_escape_string($name);
		$phone = mysql_real_escape_string($phone);
		$content = mysql_real_escape_string($content);
		$email = mysql_real_escape_string($email);
		$asktime = time();
		$state = PRO_ASK;

		$sql = "select * from depart where id = '$depart_id'";
		$result_depart = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result_depart)){
			return output(OUTPUT_ERROR, "你提交的问题分类已不存在，请重新选择分类");
		}

		if(intval($row['center']) == 0){
			return output(OUTPUT_ERROR, "你提交的问题的分类的管理员不存在，等待添加管理员后再提交");	
		}


		//insert pro
		$userId = getUserId($email);
		$sql = "INSERT INTO `problem`(`user_id`, `title`, `content`, `phone`, `block_id`, `depart_id`, `state`, `realName`) VALUES ('$userId', '$title', '$content', '$phone', '$block_id', '$depart_id', '$state', '$name')";
		mysql_query($sql, $conn);

		// get pro id
		$sql = "SELECT `id` FROM `problem` WHERE `user_id` = '$userId' and `title` = '$title' and `phone` = '$phone' and `block_id` = '$block_id' and `user_id` = '$userId' and `depart_id` = '$depart_id' and `block_id` = '$block_id' ORDER BY  `id` DESC";
		$result_pro = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result_pro);
		$proId = $row['id'];

		addProblemTime($proId, $userId, $asktime, $state);

		$sql = "SELECT * FROM `depart` WHERE `id` = '$depart_id'";
		$result_depart = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result_depart);
		$sendToCenter = $row['sendToCenter'];

		if ($sendToCenter == 1) {
			$center = $row['center'];
			$state = PRO_PASS;
			addProblemTime($proId, $center, $asktime, $state);

			sendMSGToAdmin($proId,"有个用户提交了一个问题,已经自动通过审核");
			sendMSGToFix($proId, $center, "有个用户提交了一个问题");
			$sql = "UPDATE `problem` SET `state` = '$state' WHERE `id` = '$proId'";
			mysql_query($sql, $conn);
		}else{

			sendMSGToAdmin($proId,"有个用户提交了一个问题");
		}

		sendMSGToUser($proId, $userId,"你好，你提交的问题会马上解决");

		return output(OUTPUT_SUCCESS, "你的问题已经提交,你可以在导航栏中的“我的反馈记录”里查询进展");

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function updateDepartAdmin() {
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}
	/*
		id:$id   depart_id
		email:$name depart manger email
		*/

	if (isset ($_POST['id']) && isset ($_POST['email']) && isset ($_POST['phone'])) {

		//get post
		$depart_id = $_POST['id'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];

		//check whether the data is null
		if (strcmp($depart_id, "") == 0 || strcmp($email, "") == 0 || strcmp($phone, "") == 0 ) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		if (!isEmail($email)) {
			return output(OUTPUT_ERROR, "邮箱格式不正确");
		}

		if (!isPhone($phone)) {
			return output(OUTPUT_ERROR, "电话号码不正确");
		}

		//Prevent sql injection
		$depart_id = mysql_real_escape_string($depart_id);
		$email = mysql_real_escape_string($email);
		$phone = mysql_real_escape_string($phone);

		//update admin
		$userId = getUserId($email);

		if($userId == 0){
			return output(OUTPUT_ERROR, "添加新邮箱时数据库出错");
		}

		if(!setUserLev($userId, "2", $phone)){
			return output(OUTPUT_ERROR, "提升管理员权限时出错");
		}

		$sql = "UPDATE `depart` SET `center` = '$userId' WHERE `id`= $depart_id";

		if(mysql_query($sql, $conn)){
			return output(OUTPUT_SUCCESS, "设置管理员成功");
		}else{
			return output(OUTPUT_ERROR, "添加管理员时出错");
		}

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}

}

function deleteDepartAdmin(){
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}
		//防止sql注入
		$id = mysql_real_escape_string($id);

		if(_deleteDepartAdmin($id)){
			return output(OUTPUT_ERROR, "管理员删除成功");
		}else{
			return output(OUTPUT_ERROR, "管理员删除失败");
		}
	}
}


function passCheck(){
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	if (isset ($_POST['id'])) {
		//获得表单数据
		$problemId = intval($_POST['id']);

		//检查表单数据是否合法
		if ($problemId == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//操作数据库
		$sql = "select * from problem where id = '$problemId'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(OUTPUT_ERROR, "这个问题已经不存在");
		}
		$state = $row["state"];

		if($state != PRO_ASK){
			return output(OUTPUT_ERROR, "这个问题已经审核过了");		
		}

		$state = PRO_PASS;
		$sql = "UPDATE `problem` SET `state`= '$state' where `id` = '$problemId'";
		$result = mysql_query($sql, $conn);

		if(!$result){
			return output(OUTPUT_ERROR, "操作失败，请刷新后再操作");		
		}

		$adminId = $_SESSION['messagefkId'];
		$userId = $row["user_id"];
		$passTime = time();

		$departId = $row["depart_id"];
		$centerId = getCenterId($departId);

		addProblemTime($problemId, $adminId, $passTime, $state);

		sendMSGToUser($problemId, $userId, "你好，你提交的问题已通过审核");
		sendMSGToFix($problemId, $centerId, "你好，有新问题提交，请处理");		

		return output(OUTPUT_SUCCESS, "操作成功");	

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function notPassCheck(){
	global $conn;

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	if (isset ($_POST['id'])) {
		//获得表单数据
		$problemId = intval($_POST['id']);

		//检查表单数据是否合法
		if ($problemId == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//操作数据库
		$sql = "select * from problem where id = '$problemId'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(OUTPUT_ERROR, "这个问题已经不存在");
		}

		$state = $row["state"];
		if($state != PRO_ASK ){
			return output(OUTPUT_ERROR, "这个问题已经处理过了");		
		}

		$state = PRO_NOT_PASS;
		$sql = "UPDATE `problem` SET `state`= '$state' where `id` = '$problemId'";
		$result = mysql_query($sql, $conn);

		if(!$result){
			return output(OUTPUT_ERROR, "审核失败，请刷新后再审核");		
		}

		$adminId = $_SESSION['messagefkId'];
		$userId = $row["user_id"];
		$passTime = time();

		addProblemTime($problemId, $adminId, $passTime, $state);

		sendMSGToUser($problemId, $userId, "你好，你提交的问题未经过审核。");		

		return output(OUTPUT_SUCCESS, "操作成功");	

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function accept(){
	global $conn;

	if(!checkLev(LEV_FIX)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	if (isset ($_POST['id'])) {
		//获得表单数据
		$problemId = intval($_POST['id']);

		//检查表单数据是否合法
		if ($problemId == 0) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//操作数据库
		$sql = "select * from problem where id = '$problemId'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(OUTPUT_ERROR, "这个问题已经不存在");
		}

		$state = $row["state"];
		if($state != PRO_PASS ){
			return output(OUTPUT_ERROR, "这个问题已经处理过了");		
		}

		$state = PRO_ACCEPT;
		$sql = "UPDATE `problem` SET `state`= '$state' where `id` = '$problemId'";
		$result = mysql_query($sql, $conn);

		if(!$result){
			return output(OUTPUT_ERROR, "审核失败，请刷新后再审核");		
		}

		$fixId = $_SESSION['messagefkId'];
		$userId = $row["user_id"];
		$acceptTime = time();

		addProblemTime($problemId, $fixId, $acceptTime, $state);

		sendMSGToUser($problemId, $userId, "你好，你的问题已经受理，现在正在维修中");	

		return output(OUTPUT_SUCCESS, "受理通过");	

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}


function finish(){

	global $conn;

	if(!checkLev(LEV_FIX)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	if (isset ($_POST['id']) && isset ($_POST['chargeContent']) && isset ($_POST['totalCharge']) && isset ($_POST['fixProple']) && isset ($_POST['fixResult'])) {
		//获得表单数据
		$problemId = intval($_POST['id']);
		$chargeContent = ($_POST['chargeContent']);
		$totalCharge = intval($_POST['totalCharge']);
		$fixProple = ($_POST['fixProple']);
		$fixResult = ($_POST['fixResult']);


		//检查表单数据是否合法
		if ($problemId == 0 || strcmp($chargeContent,"") == 0 || strcmp($fixResult,"") == 0 || strcmp($fixProple,"") == 0 ) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}


		//操作数据库
		$sql = "select * from problem where id = '$problemId'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(OUTPUT_ERROR, "这个问题已经不存在");
		}
		$userId = $row["user_id"];
		$state = $row["state"];
		if($state != PRO_ACCEPT ){
			return output(OUTPUT_ERROR, "这个问题已经处理过了");		
		}

		//prevent xss
		$chargeContent = xss($chargeContent);
		$fixProple = xss($fixProple);
		$fixResult = xss($fixResult);

		//Prevent sql injection
		$chargeContent = mysql_real_escape_string($chargeContent);
		$fixProple = mysql_real_escape_string($fixProple);
		$fixResult = mysql_real_escape_string($fixResult);

		$askTime = getStateTime($problemId, PRO_ASK);
		$finishtime = time();
		$totalTime = $finishtime - $askTime;

		$state = PRO_FINISH;
		$sql = "UPDATE `problem` SET `fixProple` = '$fixProple',`total_time` = '$totalTime',`totalCharge` = '$totalCharge',`state`= '$state', `chargeContent` = '$chargeContent', `result` = '$fixResult' where `id` = '$problemId'";
		$result = mysql_query($sql, $conn);

		if(!$result){
			return output(OUTPUT_ERROR, "审核失败，请刷新后再审核");		
		}

		$fixId = $_SESSION['messagefkId'];

		$acceptTime = time();

		addProblemTime($problemId, $fixId, $finishtime, $state);

		sendMSGToUser($problemId, $userId, "你好，你的问题完成，请去评价");
		sendMSGToAdmin($problemId,"问题编号为 $problemId 的问题已维修完成");

		return output(OUTPUT_SUCCESS, "问题完成");	
	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}


}


function over(){
	global $conn;


	if(checkLev(LEV_VISITOR)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	if (isset ($_POST['id']) && isset ($_POST['starConetnt']) && isset ($_POST['star'])) {
		//获得表单数据
		$problemId = intval($_POST['id']);
		$starConetnt = ($_POST['starConetnt']);
		$star = intval($_POST['star']);

		//检查表单数据是否合法
		if ($problemId == 0 || strcmp($starConetnt,"") == 0 ) {
			return output(OUTPUT_ERROR, "表单填写不完整");
		}

		//检查表单数据是否合法
		if ($star <1 || $star > 5) {
			return output(OUTPUT_ERROR, "非法数据");
		}

		//操作数据库
		$sql = "select * from problem where id = '$problemId'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(OUTPUT_ERROR, "$problemId 这个问题已经不存在");
		}
		$userId = $row["user_id"];
		$state = $row["state"];
		if($state != PRO_FINISH ){
			return output(OUTPUT_ERROR, "这个问题已经处理过了");		
		}

		$_userId =  $_SESSION['messagefkId'];

		if($_userId != $userId){
			return output(OUTPUT_ERROR, "你没有此操作的权限");
		}

		//prevent xss
		$starConetnt = xss($starConetnt);

		//Prevent sql injection
		$starConetnt = mysql_real_escape_string($starConetnt);

		$overtime = time();

		$state = PRO_OVER;
		$sql = "UPDATE `problem` SET `state`= '$state', `star` = '$star' , `starContent` = '$starConetnt' where `id` = '$problemId'";
		$result = mysql_query($sql, $conn);

		if(!$result){
			return output(OUTPUT_ERROR, "操作失败，请刷新后再操作");		
		}

		addProblemTime($problemId, $_userId, $overtime, $state);

		sendMSGToAdmin($problemId,"编号为 $problemId 的问题已评价");

		return output(OUTPUT_SUCCESS, "评价完成");	

	} else {
		return output(OUTPUT_ERROR, "表单填写不完整");
	}
}

function everyYearNumberOfRepairs(){
	global $conn;
	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}
	$min_year = 0;

	$res = array();

	$sql = "select min(time) time from problem_time where state = '1'";
	$result_min_time = mysql_query($sql);
	$row_min_time = mysql_fetch_array($result_min_time);
	if($row_min_time){
		$min_year = $row_min_time["time"];
	}else{
		return output(OUTPUT_ERROR, "暂时没有数据");
	}
	$min_year = date("Y",$min_year) - 1;

	$sql = "select max(time) time from problem_time where state = '1'";
	$result_max_time = mysql_query($sql);
	$row_max_time = mysql_fetch_array($result_max_time);
	if($row_max_time){
		$max_year = $row_max_time["time"];
	}else{
		return output(OUTPUT_ERROR, "暂时没有数据");
	}
	$max_year = date("Y",$max_year);

	$year = array();
	for($i = $min_year; $i <= $max_year; $i++){
		$year[] = $i;
	}
	$res["xAxis"] = $year;
	$res["data"] = array();

	$result_depart = mysql_query("SELECT * FROM depart");

	while($row_depart = mysql_fetch_array($result_depart)){
		$depart_id=$row_depart['id'];
		$depart_name=$row_depart['name'];

		$depart = array();

		for($now_year = $min_year; $now_year<= $max_year; $now_year++){
			$startTime = mktime(0,0,0,1,1,$now_year);
			$endTime = mktime(23,59,59,12,31,$now_year);
			$sql = "select count(*) num from problem_time where (time between $startTime and $endTime) and state = '1' and pro_id in (select id from problem where depart_Id = '$depart_id')";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$depart[] = $row["num"];
		}
		$res["data"][] = array(
		  "name"=>$depart_name,
		"data"=>$depart
		);
	}
	return output(OUTPUT_SUCCESS, $res);
}

function proportionOfRepairs(){
	global $conn;
	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	$sql = "select count(*) num from problem";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$allNum = $row["num"];
	$res = array();
	$tmp = 0;

	if($allNum == 0){
		$res[] = array(
              "name"=>"暂无数据",
              "y"=>100
		);
		return output(OUTPUT_SUCCESS, $res);
	}

	$result_depart = mysql_query("SELECT * FROM depart");
	while($row_depart = mysql_fetch_array($result_depart)){
		$depart_id=$row_depart['id'];
		$depart_name=$row_depart['name'];

		$sql = "select count(*) num from problem where depart_Id = '$depart_id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$res[] = array(
		  "name"=>$depart_name,
		  "y"=>$row["num"] * 100 /$allNum
		);
		$tmp += $row["num"];
	}
	$res[] = array(
          "name"=>"other",
          "y"=>($allNum - $tmp) * 100 /$allNum
	);
	return output(OUTPUT_SUCCESS, $res);

}


function getProportionOfDepart(){

	if(!checkLev(LEV_ADMIN)){
		return output(OUTPUT_ERROR, "你没有次操作的权限");
	}

	global $conn;

	if (isset ($_POST['departName'])) {
		$departName = $_POST['departName'];
		$depart_id = getDepartIdByName($departName);
		$sql = "select count(*) num from problem where depart_Id = '$depart_id'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$allNum = $row["num"];

		$res = array();


		if($allNum == 0){
			$res[] = array(
	          "name"=>"暂无数据",
	          "y"=>100
			);
			return output(OUTPUT_SUCCESS, $res);
		}

		$tmp = 0;

		$result_depart = mysql_query("SELECT * FROM map_block_depart where depart_id = '$depart_id'");
		while($row_depart = mysql_fetch_array($result_depart)){
			$block_id=$row_depart['block_id'];

			$result_block = mysql_query("SELECT name FROM block where id = '$block_id'");
			$row_block = mysql_fetch_array($result_block);
			$block_name=$row_block['name'];

			$sql = "select count(*) num from problem where block_id = '$block_id'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$res[] = array(
          "name"=>$block_name,
          "y"=>$row["num"] * 100 /$allNum
			);
			$tmp += $row["num"];
		}
		$res[] = array(
          "name"=>"other",
          "y"=>($allNum - $tmp) * 100 /$allNum
		);
		return output(OUTPUT_SUCCESS, $res);
	}else{
		return output(OUTPUT_ERROR, "非法操作");
	}
}



?>
