<?php

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

function get_manger_block($code){
	global $conn;
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