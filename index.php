<?php
session_start();
require_once("inc/init.php");
require_once('inc/function.php');
$title = "信息反馈系统";
require_once('inc/header.inc.php');

$messagefk_id    = $_SESSION['messagefk_id'];
$messagefk_email = $_SESSION['messagefk_email'];
$messagefk_lev   = $_SESSION['messagefk_lev'];
if(strcmp($messagefk_lev, "") == 0){
	$messagefk_lev = 0;
}

$type  =  0;
?>
<div class="wrap">
<?php require_once('inc/top.inc.php'); ?>
<?php require_once('inc/nav.inc.php'); ?>
	<div class="content">
		<div class="row">
			<div class="span2 bs-docs-sidebar">
				<ul class="nav nav-list bs-docs-sidenav">
					<li class="manger_nav1 active">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',1);">
							<i class="icon-chevron-right"></i> 全部
						</a>
					</li>
					<li  class="manger_nav2">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',2);">
							<i class="icon-chevron-right"></i> 正在审核中
						</a>
					</li>
					<li  class="manger_nav4">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',3);">
							<i class="icon-chevron-right"></i> 正在受理中
						</a>
					</li>
					<li  class="manger_nav5">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',4);">
							<i class="icon-chevron-right"></i> 正在维修中
						</a>
					</li>
					<li  class="manger_nav6">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',5);">
							<i class="icon-chevron-right"></i> 等待评价中
						</a>
					</li>
					<li  class="manger_nav6">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',6);">
							<i class="icon-chevron-right"></i> 完成的
						</a>
					</li>
					<li  class="manger_nav3">
						<a href="javascript:void(0);" onclick="getHtml('all_nav',7);">
							<i class="icon-chevron-right"></i> 未通过审核
						</a>
					</li>
				</ul>
			</div>
			<div class="span7 mini-layout">
				<table class="table table-striped table-bordered table-condensed tablesorter" style="word-break:break-all;">
					<thead>
						 <tr>
							<th class="header headerSortDown" style="cursor:pointer;">编号</th>
							<th class="header headerSortDown" style="cursor:pointer;">服务项目</th>
							<th class="header headerSortDown" style="cursor:pointer;">标题</th>
							<th class="header headerSortDown" style="cursor:pointer;">申报人</th>
							<th class="header headerSortDown" style="cursor:pointer;">申报时间</th>
							<th class="header headerSortDown" style="cursor:pointer;">状态</th>
						</tr>
					</thead>
					<tbody>
	<?php 
		$sql = "SELECT * FROM `problem` ORDER BY  `id` DESC";
		$result = mysql_query($sql ,$conn);
		while($row=mysql_fetch_array($result)) {
			$pro_id = $row['id'];
			$user_id = $row['user_id'];
			$user_email = getUserEmail($user_id);
			
			$pro_title = $row['title'];
			$depart_id = $row['depart_id'];
			$depart_name = getDepartName($depart_id);
			
			$total_time = $row['total_time'];
			$state = $row['state'];
			
			$asktime = getStateTime($pro_id,"1");
			$asktime = date("Y-m-d h:i:s",$asktime);
			
			
			if($state == 1){
				$state = "等到管理员审核";
				$admin = "--";
				$adminTime = "--";
				$total_time = "--";
			}else if($state == 2){
				
			}else if($state == 3){
				
			}
			
			$tr  = "";
			$tr .= "<tr data-id=\"$pro_id\" id=\"contestant_$pro_id\">";
			$tr .= "<td>$pro_id</td>";
			$tr .= "<td>$depart_name</td>";
			$tr .= "<td><a href=''>$pro_title</a></td>";
			$tr .= "<td>$asktime</td>";
			$tr .= "<td>$admin</td>";
			$tr .= "<td>$adminTime</td>";
			$tr .= "<td>$total_time</td>";
			$tr .= "<td>$state</td>";
			$tr .= "</tr>";
			echo $tr;
		}
	?>
							
						
					</tbody>
				</table>
			</div>
		</div>
	</div>

<script>
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
});
</script>
<?php include_once('inc/footer.inc.php'); ?>
<?php include_once('inc/end.php'); ?>

