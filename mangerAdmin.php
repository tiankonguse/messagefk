<?php
session_start();
require_once("inc/init.php");
$title = "信息反馈系统管理页面";
include_once('inc/header.inc.php');

$messagefk_id    = $_SESSION['messagefk_id'];
$messagefk_email = $_SESSION['messagefk_email'];
$messagefk_lev   = $_SESSION['messagefk_lev'];
if(strcmp($messagefk_lev, "3") != 0){
	header('Location:login.php');
}

$name = $_GET["name"];
$state = $_GET["state"];

if(strcmp($name,"") == 0){
	$name = "nav";
	$state = 1;
}

$type  =  6;
?>
<div class="wrap container">
<?php include_once('inc/top.inc.php'); ?>
<?php include_once('inc/nav.inc.php'); ?>
	<div class="content">
		<div class="row">
			<div class="span2 bs-docs-sidebar">
				<ul class="nav nav-list bs-docs-sidenav">
					<li class="manger_admin_nav1 active">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',1);">
							<i class="icon-chevron-right"></i> 管理分类
						</a>
					</li>
					<li  class="manger_admin_nav2">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',2);">
							<i class="icon-chevron-right"></i> 添加管理员
						</a>
					</li>
					<li  class="manger_admin_nav3">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',3);">
							<i class="icon-chevron-right"></i> 未受理的问题
						</a>
					</li>
					<li  class="manger_admin_nav4">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',4);">
							<i class="icon-chevron-right"></i> 正在维修中的问题
						</a>
					</li>
					<li  class="manger_admin_nav5">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',5);">
							<i class="icon-chevron-right"></i> 未评价的问题
						</a>
					</li>
					<li  class="manger_admin_nav6">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',6);">
							<i class="icon-chevron-right"></i> 已评价的问题
						</a>
					</li>
				</ul>
			</div>
			<div class="span7 mini-layout">
				
			</div>
		</div>
	</div>

<script>


function remove_active(){
	$(".content .row ul.nav li.active").removeClass("active");
}

function ajax_fun(name,state){
	$.post("inc/ajax.php",{
		name:name,
		state:state
	},function(d){
		if(d.code==0){
			$(".span7.mini-layout").html(d.message);
		}
	},"json");
}

function getHtml(name,state){
	if(name == 'nav_admin'){
		remove_active();
		$(".manger_admin_nav"+state).addClass("active");
		ajax_fun(name,state);
	}else if(name == 'depart'){
		// if name is depart, state is depart's id.
		ajax_fun(name,state);
	}
}
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
	getHtml(<?php echo "\"$name\",$state";?>);
});
</script>
<?php include_once('inc/footer.inc.php'); ?>
<?php include_once('inc/end.php'); ?>
