<?php

function isEmail($email){
	return preg_match('/^.+?@.+?\..+?$/', $email);
}

function isPhone($phone){
	return preg_match('/^[0-9]{11,11}$/', $phone);
}

//$email is security and correct. email is not exit.
function addUser($email, $lev) {
	global $conn;
	$sql = "insert into `user` (`email`,`lev`) values('$email', '$lev')";
	return mysql_query($sql, $conn);
}

//$email is security and correct.
function getUserId($email) {
	global $conn;
	$sql = "select * from user where email = '$email'";
	$result_user = mysql_query($sql, $conn);

	if (!($row = mysql_fetch_array($result_user))) {
		//first add user
		if(!addUser($email, "1")) return 0;
		$sql = "select * from user where email = '$email'";
		$result_user = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result_user);
	}
	return $row['id'];
}

function setUserLev($userId, $lev, $phone) {
	global $conn;
	$sql = "UPDATE `user` SET `lev` = '$lev' ,`phone` = '$phone' WHERE `id`= $userId";
	return mysql_query($sql, $conn);
}

function delete_depart_admin(){
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$id = mysql_real_escape_string($id);
		
		$sql = "select * from `depart` where `id` = '$id'";
		$result = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result)){
			return output(6, "这个分类不存在，可能已被管理员删除！");
		}
		$userId = $row["center"];
		
		$sql = "select count(*) num from `depart` where `center` = '$userId'";;
		$result = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result);
		$num = $row["num"];

		if($num == 0){
			return output(6, "这个用户可能不是管理员。");
		}
		
		if($num == 1){
			if(!mysql_query("UPDATE `user` SET `lev` = '1'  WHERE `id`= $userId", $conn)){
				return output(6, "删除管理员时出错");
			}
		}
		
		if(mysql_query("UPDATE `depart` SET `center` = NULL WHERE `id`= $id", $conn)){
			return output(0, "删除管理员成功");
		}else{
			return output(6, "删除管理员时出错");
		}
		
		
	}
	
	
}

function update_depart_admin() {
	global $conn;

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
			return output(6, "表单填写不完整");
		}

		if (!isEmail($email)) {
			return output(4, "邮箱格式不正确");
		}
		
		if (!isPhone($phone)) {
			return output(4, "电话号码不正确");
		}

		//Prevent sql injection
		$depart_id = mysql_real_escape_string($depart_id);
		$email = mysql_real_escape_string($email);
		$phone = mysql_real_escape_string($phone);

		//update admin
		$userId = getUserId($email);
		
		if($userId == 0){
			return output(6, "添加新邮箱时数据库出错");
		}
		
		if(!setUserLev($userId, "2", $phone)){
			return output(6, "提升管理员权限时出错");
		}
		
		$sql = "UPDATE `depart` SET `center` = '$userId' WHERE `id`= $depart_id";
		
		if(mysql_query($sql, $conn)){
			return output(0, "设置管理员成功");
		}else{
			return output(6, "添加管理员时出错");
		}

	} else {
		return output(6, "表单填写不完整");
	}

}

function add_question() {
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
			return output(6, "表单填写不完整");
		}

		if (!preg_match('/^[0-9]{11,11}$/', $phone)) {
			return output(4, "电话号码不正确");
		}

		if (!preg_match('/^.+?@.+?\..+?$/', $email)) {
			return output(4, "邮箱格式不正确");
		}
		
		
		//Prevent sql injection
		$title = mysql_real_escape_string($title);
		$depart_id = mysql_real_escape_string($depart_id);
		$block_id = mysql_real_escape_string($block_id);
		$name = mysql_real_escape_string($name);
		$phone = mysql_real_escape_string($phone);
		$content = mysql_real_escape_string($content);
		$email = mysql_real_escape_string($email);
		$asktime = time();
		$state = "1";
		
		$sql = "select * from depart where id = '$depart_id'";
		$result_depart = mysql_query($sql, $conn);
		if(!$row = mysql_fetch_array($result_depart)){
			return output(6, "你提交的问题分类已不存在，请重新选择分类");
		}
		
		if(intval($row['center']) == 0){
			return output(6, "你提交的问题的分类的管理员不存在，等待添加管理员后再提交");	
		}
		
		//insert pro
		$userId = getUserId($email);
		$sql = "INSERT INTO `problem`(`user_id`, `title`, `content`, `phone`, `block_id`, `depart_id`, `state`) VALUES ('$userId', '$title', '$content', '$phone', '$block_id', '$depart_id', '$state')";
		mysql_query($sql, $conn);

		// get pro id
		$sql = "SELECT `id` FROM `problem` WHERE `user_id` = '$userId' and `title` = '$title' and `phone` = '$phone' and `block_id` = '$block_id' and `user_id` = '$userId' and `depart_id` = '$depart_id' and `block_id` = '$block_id' ORDER BY  `id` DESC";
		$result_pro = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result_pro);
		$proId = $row['id'];

		addProblemTime($proId, $userId, $asktime, $state);

		sendMSGToUser($proId, $userId);
		sendMSGToAdmin($proId);

		$sql = "SELECT * FROM `depart` WHERE `id` = '$depart_id'";
		$result_depart = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result_depart);
		$sendToCenter = $row['sendToCenter'];

		if ($sendToCenter == 1) {
			$center = $row['center'];
			$state++;
			addProblemTime($proId, $center, $asktime, $state);

			sendMSGToCenter($proId, $center);
			$sql = "UPDATE `problem` SET `state` = '$state' WHERE `id` = '$proId'";
			mysql_query($sql, $conn);
		}

		return output(0, "你的问题已经提交,你可以在导航栏中的“我的反馈记录”里查询进展");

	} else {
		return output(6, "表单填写不完整");
	}
}

function addProblemTime($proId, $userId, $time, $state) {
	global $conn;
	$sql = "INSERT INTO `problem_time`(`pro_id`, `user_id`, `time`, `state`) VALUES ('$proId', '$userId', '$time', '$state')";
	mysql_query($sql, $conn);
}

function get_depart_block() {
	global $conn;
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

function delete_block() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$id = mysql_real_escape_string($id);

		center_map_block($id);

		//实现本函数功能
		$sql = "DELETE FROM `block` WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(0, "子分类删除成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

function update_block() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['name']) && isset ($_POST['id'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$id = mysql_real_escape_string($id);

		//实现本函数功能
		$sql = "UPDATE `block` SET `name`='$name' WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(0, "子分类名称更改成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

function add_block() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['name']) || isset ($_POST['name'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$depart_id = $_POST['depart_id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($depart_id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$depart_id = mysql_real_escape_string($depart_id);

		//实现此函数功能前检查此操作是否合法
		$sql = "select * from `block` where name = '$name'";
		$result = mysql_query($sql, $conn);
		if ($result && mysql_num_rows($result) > 0) {
			return output(3, "该分类已存在");
		}

		//插入子分类
		$sql = "insert into `block` (`name`) values('$name')";
		$result = mysql_query($sql, $conn);

		//得到子分类的id
		$sql = "SELECT `id` FROM `block` WHERE name = '$name'";
		$result = mysql_query($sql, $conn);
		$row = mysql_fetch_array($result);
		$block_id = $row['id'];

		//建立大分类与子分类的联系
		$result = map_block_depart($block_id, $depart_id);

		if ($result) {
			return output(0, "子分类添加成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

function center_map_block_depart($block_id, $depart_id) {
	global $conn;
	$sql = "DELETE FROM `map_block_depart` WHERE `block_id` = '$block_id' and `depart_id` = '$depart_id'";
	$result = mysql_query($sql, $conn);
	return $result;
}

function center_map_block($block_id) {
	global $conn;
	$sql = "DELETE FROM `map_block_depart` WHERE `block_id` = '$block_id' ";
	$result = mysql_query($sql, $conn);
	return $result;
}

function center_map_depart($depart_id) {
	global $conn;
	$sql = "DELETE FROM `map_block_depart` WHERE `depart_id` = '$depart_id'";
	$result = mysql_query($sql, $conn);
	return $result;
}

function map_block_depart($block_id, $depart_id) {
	global $conn;

	$sql = "INSERT INTO `map_block_depart`(`block_id`, `depart_id`) VALUES ('$block_id','$depart_id')";
	$result = mysql_query($sql, $conn);
	return $result;
}

function delete_depart() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['id'])) {
		//获得变量的数据
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$id = mysql_real_escape_string($id);

		center_map_depart($id);

		//实现本函数功能
		$sql = "DELETE FROM `depart` WHERE `id` = '$id'";
		$result = mysql_query($sql, $conn);
		if ($result) {
			return output(0, "分类删除成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

function update_depart() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['name']) && isset ($_POST['id'])) {
		//获得变量的数据
		$name = $_POST['name'];
		$id = $_POST['id'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0 || strcmp($id, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);
		$id = mysql_real_escape_string($id);

		//实现本函数功能
		$sql = "UPDATE `depart` SET `name`='$name' WHERE `id` = '$id'";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(0, "分类名称更改成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

function add_depart() {
	global $conn;
	//检查变量是否存在
	if (isset ($_POST['name'])) {
		//获得变量的数据
		$name = $_POST['name'];

		//检查表单数据是否合法
		if (strcmp($name, "") == 0) {
			return output(6, "表单填写不完整");
		}

		//防止sql注入
		$name = mysql_real_escape_string($name);

		//实现此函数功能前检查此操作是否合法
		$sql = "select * from `depart` where name = '$name'";
		$result = @ mysql_query($sql, $conn);
		if ($result && mysql_num_rows($result) > 0) {
			return output(3, "该分类已存在");
		}

		//实现本函数功能
		$sql = "insert into `depart` (`name`) values('$name')";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			return output(0, "分类添加成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}
	} else {
		return output(6, "表单填写不完整");
	}
}

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
			return output(6, "表单填写不完整");
		}

		if (strcmp($password1, $password2) != 0) {
			return output(5, "输入的两次密码不同");
		}

		if (!preg_match('/^.+?@.+?\..+?$/', $email)) {
			return output(4, "邮箱格式不正确");
		}

		//防止sql注入
		$email = mysql_real_escape_string($email);
		$password = sha1(SALT . $password1);
		$password = mysql_real_escape_string($password);

		//实现此函数功能前检查此操作是否合法
		$sql = "select * from `user` where email = '$email'";
		$result = @ mysql_query($sql, $conn);
		if ($result && mysql_num_rows($result) > 0) {
			return output(3, "该邮箱已存在");
		}

		//实现本函数功能
		$sql = "insert into `user` (`email`,`lev`) values('$email','0')";
		$result = @ mysql_query($sql, $conn);
		if ($result) {
			$_SESSION['email'] = $email;
			$_SESSION['lev'] = 0;
			return output(0, "注册成功");
		} else {
			return output(2, "数据库操作失败，请联系管理员");
		}

	} else {
		return output(6, "表单填写不完整");
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
			return output(6, "表单填写不完整");
		}

		if (!preg_match('/^.+?@.+?\..+?$/', $email)) {
			return output(4, "邮箱格式不正确");
		}

		//防止sql注入
		$email = mysql_real_escape_string($email);
		$password = sha1(SALT . $password);

		//操作数据库
		$sql = "select * from user where email = '$email'";
		$result = @ mysql_query($sql, $conn);
		if ($result && $row = mysql_fetch_array($result)) {
			$_SESSION['messagefk_id'] = $row['id'];
			$_SESSION['messagefk_email'] = $row['email'];
			$_SESSION['messagefk_lev'] = $row['lev'];
			return output(0, "登录成功");
		} else {
			return output(12, "用户名或密码错误");
		}

	} else {
		return output(6, "表单填写不完整");
	}
}
?>