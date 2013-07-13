<?php

function getDepartName($depart_id){
	global $conn;
	$sql = "select * from `depart` where `id` = '$depart_id'";
	$result = mysql_query($sql ,$conn);
	$row = mysql_fetch_array($result);
	return $row['name'];
}

function getTime($pro_id, $state){
	global $conn;
	$sql = "select * from `problem_time` where `pro_id` = '$pro_id' and `state` = '$state'";
	$result = mysql_query($sql ,$conn);
	$row = mysql_fetch_array($result);
	return $row['time'];
}

function get_user_email($userId){

	$notSetCenter = "暂时没有设置管理员";

	if($userId == 0)return $notSetCenter;

	$userId = intval($userId);

	global $conn;

	$sql = "select * from user where `id` = '$userId'";
	$result = mysql_query($sql ,$conn);
	if($result && $row=mysql_fetch_array($result)){
		return $row['email'];
	}else{
		return $notSetCenter;
	}


}

function checkIfIs($lev){
	$messagefk_lev   = intval($_SESSION['messagefk_lev']);
	return strcmp($lev,$messagefk_lev);
}

function get_manger_block($code){
	global $conn;

	if(checkIfIs(3) != 0){
		return output(0, "你的权限不足");
	}

	$html = "";

	$html .= "<table class=\"table table-striped table-bordered table-hover table-condensed tablesorter\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th>已有子分类</th>";
	$html .= "<th>操作</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$sql = "SELECT * FROM `block` WHERE id in (SELECT `block_id` FROM `map_block_depart` WHERE depart_id = '$code')";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$id   = $row['id'];
		$name   = $row['name'];
		$html .= "
			<tr data-id='$id' id='block$id'>
					<td>$name</td>
					<td style='text-align:center;'>
						<div class='btn-group'  data-toggle='buttons-radio'>
							<button class='btn btn-info' onclick=\"click_update_block($id,'$name')\">修改</button>
							<button class='btn btn-danger' onclick=\"click_delete_block($id, '$name')\">删除</button>
						</div>
					</td>
			</tr>		
		";
	}
	$html .= "<tr>";
	$html .= "<td colspan=\"2\" style=\"text-align:center;\">";
	$html .= "<button class='btn btn-success' onclick='click_add_block()'>增加子分类</button>";
	$html .= "</td>";
	$html .= "</tr>";
	$html .= "</tbody>";
	$html .= "</table>";
	$html .= "<script>var \$depart_id = $code;</script>";

	return output(0, $html);
}

function get_manger_depart(){

	global $conn;

	if(checkIfIs(3) != 0){
		return output(0, "你的权限不足");
	}


	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-hover table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th>已有分类</th>";
	$html .= "<th>操作分类</th>";
	$html .= "<th>管理员</th>";
	$html .= "<th>操作管理员</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$sql = "select * from depart";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$id   = $row['id'];
		$name = $row['name'];
		$sendTocenter = $row['center'];

		$userId = intval($sendTocenter);
		$userEmail = get_user_email($userId);

		$html .= "
			<tr data-id='$id' id='depart$id'>
				<td>
					<a href=\"javascript:void(0);\" onclick=\"getHtml('depart',$id);\">	$name</a>
				</td>
				<td style='text-align:center;'>
					<div class='btn-group'  data-toggle='buttons-radio'>
						<button class='btn btn-info' onclick=\"click_update_depart($id,'$name')\">修改</button>
						<button class='btn btn-danger' onclick=\"click_delete_depart($id, '$name')\">删除</button>
					</div>
				</td>
				<td>
					<input  type=\"text\"   disabled=\"\" value=\"$userEmail\">
				</td>
				<td>
					<div class='btn-group'  data-toggle='buttons-radio'>
						<button class='btn btn-info' onclick=\"click_update_depart_admin($id,'$name')\">修改</button>
						<button class='btn btn-danger' onclick=\"click_delete_depart_admin($id, '$name','$userEmail')\">删除</button>
					</div>
				</td>
			</tr>";
	}
	$html .= "<tr>";
	$html .= "<td colspan='4' style='text-align:center;'>";
	$html .= "<button class='btn btn-success' onclick='click_add_depart()'>增加</button>";
	$html .= "</td>";
	$html .= "</tr>";
	$html .= "</tbody>";
	$html .= "</table>";
	return output(0, $html);

}

function get_admin_wait_check_problem(){
	global $conn;

	if(checkIfIs(3) != 0){
		return output(0, "你的权限不足");
	}

	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">编号</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">服务项目</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">标题</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">申报时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$sql = "SELECT * FROM `problem` WHERE `state` = '1' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);

		$asktime = getTime($pro_id,"1");
		$asktime = date("Y-m-d h:i:s",$asktime);

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$asktime</td>";
		$tr .= "<td>等到管理员审核</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function get_admin_wait_accept_problem(){
	global $conn;

	if(checkIfIs(3) != 0){
		return output(0, "你的权限不足");
	}

	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">编号</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">服务项目</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">标题</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">申报时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">审核时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";


	$sql = "SELECT * FROM `problem` WHERE `state` = '2' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);

		$asktime = getTime($pro_id,"1");
		$asktime = date("Y-m-d h:i:s",$asktime);

		$sql = "SELECT * FROM `problem_time` WHERE `pro_id` = '$pro_id' and `state` = '2'";
		$result_problem_time = mysql_query($sql ,$conn);
		$row_problem_time = mysql_fetch_array($result_problem_time);
		$acceptTime = $row_problem_time["time"];
		$acceptTime = date("Y-m-d h:i:s",$acceptTime);

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$asktime</td>";
		$tr .= "<td>$acceptTime</td>";
		$tr .= "<td>未受理的问题</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}


function get_admin_now_fixxing_problem(){
	global $conn;

	if(checkIfIs(3) != 0){
		return output(0, "你的权限不足");
	}

	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">编号</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">服务项目</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">标题</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">申报时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">受理时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";


	$sql = "SELECT * FROM `problem` WHERE `state` = '3' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);

		$asktime = getTime($pro_id,"1");
		$asktime = date("Y-m-d h:i:s",$asktime);

		$sql = "SELECT * FROM `problem_time` WHERE `pro_id` = '$pro_id' and `state` = '3'";
		$result_problem_time = mysql_query($sql ,$conn);
		$row_problem_time = mysql_fetch_array($result_problem_time);
		$acceptTime = $row_problem_time["time"];
		$acceptTime = date("Y-m-d h:i:s",$acceptTime);

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$asktime</td>";
		$tr .= "<td>$acceptTime</td>";
		$tr .= "<td>正在维修中</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function get_user_all_problem(){
	global $conn;

	if(checkIfIs(0) == 0){
		return output(0, "请先登录再操作");
	}

	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">编号</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">服务项目</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">标题</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">申报时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">审核时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">受理时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">完成时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$userId    = intval($_SESSION['messagefk_id']);
	$sql = "SELECT * FROM `problem` WHERE `user_id` = '$userId' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = "等待管理员审核";

		$passTime = "--:--:--";;
		$acceptTime = "--:--:--";
		$finishTime = "--:--:--";

		if($state == 6){
			$stateHtml = "审核未通过";
		}else{
			if($state >= 2){
				$passTime = getTime($pro_id,"2");
				$passTime = date("Y-m-d h:i:s",$passTime);
				$stateHtml = "等待管理员受理";
			}
				
				
			if($state >= 3){
				$acceptTime = getTime($pro_id,"3");
				$acceptTime = date("Y-m-d h:i:s",$acceptTime);
				$stateHtml = "正在维修中";
			}

				
			if($state >= 4){
				$finishTime = getTime($pro_id,"4");
				$finishTime = date("Y-m-d h:i:s",$finishTime);
				$stateHtml = "等待评价";
			}
				
			if($state >= 5){
				$stateHtml = "已完成的问题";
			}
		}

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$passTime</td>";
		$tr .= "<td>$acceptTime</td>";
		$tr .= "<td>$finishTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}


function get_user_wait_pass_problem(){
	global $conn;

	if(checkIfIs(0) == 0){
		return output(0, "请先登录再操作");
	}

	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-condensed\" style=\"word-break:break-all;\">";
	$html .= "<thead>";
	$html .= "<tr>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">编号</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">服务项目</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">标题</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">申报时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">审核时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">受理时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">完成时间</th>";
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$userId    = intval($_SESSION['messagefk_id']);
	$sql = "SELECT * FROM `problem` WHERE `user_id` = '$userId' and `state` = '1' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = "等待管理员审核";

		$passTime = "--:--:--";;
		$acceptTime = "--:--:--";
		$finishTime = "--:--:--";

		if($state == 6){
			$stateHtml = "审核未通过";
		}else{
			if($state >= 2){
				$passTime = getTime($pro_id,"2");
				$passTime = date("Y-m-d h:i:s",$passTime);
				$stateHtml = "等待管理员受理";
			}
				
				
			if($state >= 3){
				$acceptTime = getTime($pro_id,"3");
				$acceptTime = date("Y-m-d h:i:s",$acceptTime);
				$stateHtml = "正在维修中";
			}

				
			if($state >= 4){
				$finishTime = getTime($pro_id,"4");
				$finishTime = date("Y-m-d h:i:s",$finishTime);
				$stateHtml = "等待评价";
			}
				
			if($state >= 5){
				$stateHtml = "已完成的问题";
			}
		}

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$passTime</td>";
		$tr .= "<td>$acceptTime</td>";
		$tr .= "<td>$finishTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}



