<?php

function getMangerDepart(){

	global $conn;

	if(!checkLev(3) ){
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
		$userEmail = getUserEmail($userId);
		
		if(strcmp($userEmail,"") == 0){
			$userEmail = "暂时没有管理员";
		}
		
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

function getMangerBlock($code){
	global $conn;

	if(!checkLev(3) ){
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


$stateName = array(
    1=>"等待审核",
    2=>"等待受理",
    3=>"等待维修",
    4=>"等待评价",
    5=>"已完成",
    6=>"未通过审核"
);

function getAdminStateProblem($state){
    global $conn;
   global $stateName;
    
	if(!checkLev(3) ){
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

	$sql = "SELECT * FROM `problem` WHERE `state` = '$state' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
	
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		
		$asktime = getStateTime($pro_id,"1");
		if($asktime == ""){
		  $asktime = "未知";
		}else{
		  $asktime = date("Y-m-d h:i:s",$asktime);
		}
		$stateHtml = getStateHtml($state);
		

		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$asktime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

//需要审核的问题
function getAdminWaitCheckProblem(){
	return getAdminStateProblem(1);
}

//需要受理的问题
function getAdminWaitAcceptProblem(){
	return getAdminStateProblem(2);
}

//正在维修的问题
function getAdminNowFixxingProblem(){
	return getAdminStateProblem(3);
}
//需要评价的问题
function getAdminWaitEvaluateProblem(){
	return getAdminStateProblem(4);
}
//完成的问题
function getAdminFinishProblem(){
	return getAdminStateProblem(5);
}
//未通过审核的问题
function getAdminNotPassProblem(){
	return getAdminStateProblem(6);
}


function getUserAllProblem(){
	global $conn;

	if(checkLev(0) ){
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
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$userId    = intval($_SESSION['messagefkId']);
	$sql = "SELECT * FROM `problem` WHERE `user_id` = '$userId' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}


function getUserStateProblem($state){
	if(checkLev(0) ){
		return output(0, "请先登录再操作");
	}
	global $conn;
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

	$userId    = intval($_SESSION['messagefkId']);
	
	$sql = "SELECT * FROM `problem` WHERE `user_id` = '$userId' and `state` = '$state' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function getUserWaitCheckProblem(){
	return getUserStateProblem(1);
}

function getUserWaitAcceptProblem(){
	return getUserStateProblem(2);
}

function getUserNowFixingProblem(){
	return getUserStateProblem(3);
}

function getUserWaitEvaluateProblem(){
	return getUserStateProblem(4);
}

function getUserFinishProblem(){
	return getUserStateProblem(5);
}

function getUserNotPassProblem(){
	return getUserStateProblem(6);
}

function getIndexAllProblem(){
	global $conn;

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

	$sql = "SELECT * FROM `problem` WHERE `state` > '1' and `state` < '6' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function getIndexStateProblem($state){
	global $conn;

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

	$userId    = intval($_SESSION['messagefkId']);
	$sql = "SELECT * FROM `problem` WHERE `state` = '$state' ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {
		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function getIndexWaitAcceptProblem(){
	return getIndexStateProblem(2);
}

function getIndexNowFixingProblem(){
	return getIndexStateProblem(3);
}

function getIndexWaitEvaluateProblem(){
	return getIndexStateProblem(4);
}

function getIndexFinishProblem(){
	return getIndexStateProblem(5);
}


function getFixAllProblem(){
	global $conn;

	if(!checkLev(2) ){
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
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$FixId    = intval($_SESSION['messagefkId']);
	$sql = "SELECT * FROM `problem` WHERE `state` > '1' and `state` < '4' and `depart_id` in (select id from depart where center = '$FixId') ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {

		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function getFixStateProblem($state){
	global $conn;

	if(!checkLev(2) ){
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
	$html .= "<th class=\"header headerSortDown\" style=\"cursor:pointer;\">状态</th>";
	$html .= "</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	$FixId    = intval($_SESSION['messagefkId']);
	$sql = "SELECT * FROM `problem` WHERE `state` = '$state' and `depart_id` in (select id from depart where center = '$FixId') ORDER BY  `id` DESC";
	$result = mysql_query($sql ,$conn);
	while($row=mysql_fetch_array($result)) {

		$pro_id = $row['id'];
		$pro_title = $row['title'];
		$depart_id = $row['depart_id'];
		$depart_name = getDepartName($depart_id);
		$state = $row['state'];

		$askTime = getStateTime($pro_id,"1");
		$askTime = date("Y-m-d h:i:s",$askTime);

		$stateHtml = getStateHtml($state);
		
		$tr  = "";
		$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
		$tr .= "<td>$pro_id</td>";
		$tr .= "<td>$depart_name</td>";
		$tr .= "<td><a href='problem.php?id=$pro_id'>$pro_title</a></td>";
		$tr .= "<td>$askTime</td>";
		$tr .= "<td>$stateHtml</td>";
		$tr .= "</tr>";
		$html .= $tr;
	}

	$html .= "</tbody>";
	$html .= "</table>";

	return output(0, $html);
}

function getFixWaitAcceptProblem(){
	return getFixStateProblem(2);
}
function getFixNowFixingProblem(){
	return getFixStateProblem(3);
}


function getAdminStatistics(){
	$t = time ();
	$className = "highcharts_t_".$t;
    $html  = "<div  class=\"$className\" style=\"min-width: 310px; height: 400px; margin: 0 auto\"></div>";
    $html .= "<script>if(everyYearNumberOfRepairs){everyYearNumberOfRepairs(\"$className\");}</script>";
    return output(0, $html);
}

