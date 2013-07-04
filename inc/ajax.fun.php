<?php

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
	$html .= "<script src=\"js/block.js\"></script>";
	$html .= "
		<div id=\"addevent\"  class=\"modal hide fade\">
		  <div class=\"modal-header\" style=\"text-align: center;cursor: move;\">
		    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
		    <h3></h3>
		  </div>
		  <div class=\"modal-body\">
		    <p>
				<span>子分类名称 : </span>
				<input id=\"addevent_name\" type=\"text\" placeholder=\"分类名称\"  class=\"longtext\" >
			</p>
		  </div>
		  <div class=\"modal-footer\">
		    <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\" >取消</button>
		    <button class=\"btn btn-primary\" onclick=\"\">确认</button>
		  </div>
		</div>	
	";
	
	return output(0, $html);
}


function get_manger_depart(){
	global $conn;
	$html = "";
	$html .= "<table class=\"table table-striped table-bordered table-hover table-condensed tablesorter\" style=\"word-break:break-all;\">";
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
					<input  type=\"text\"   disabled=\"\">
				</td>
				<td>
					<div class='btn-group'  data-toggle='buttons-radio'>
						<button class='btn btn-info' onclick=\"click_update_depart_admin($id,'$name')\">修改</button>
						<button class='btn btn-danger' onclick=\"click_delete_depart_admin($id, '$name')\">删除</button>
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
	
	$html .= "<script src=\"js/depart.js\"></script>";
	
	$html .= "
	<div id=\"addevent\"  class=\"modal hide fade\">
	  <div class=\"modal-header\" style=\"text-align: center;cursor: move;\">
	    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
	    <h3></h3>
	  </div>
	  <div class=\"modal-body\">
	    <p>
			<span>分类名称 : </span>
			<input id=\"addevent_name\" type=\"text\" placeholder=\"分类名称\"  class=\"longtext\" >
		</p>
	  </div>
	  <div class=\"modal-footer\">
	    <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\" >取消</button>
	    <button class=\"btn btn-primary\" onclick=\"\">确认</button>
	  </div>
	</div>";
	
	return output(0, $html);
	
}