<?php
session_start();
require_once("inc/init.php");
$title = "信息反馈系统管理页面";
include_once('inc/header.inc.php');

$messagefkId    = $_SESSION['messagefkId'];
$messagefkEmail = $_SESSION['messagefkEmail'];
$messagefkLev   = $_SESSION['messagefkLev'];

if(strcmp($messagefkLev, "3") != 0){
	header('Location:login.php');
}

$name = $_GET["name"];
$state = $_GET["state"];

if(strcmp($name,"") == 0){
	$name = "nav_admin";
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
							<i class="icon-chevron-right"></i> 等待审核的问题
						</a>
					</li>
					<li  class="manger_admin_nav3">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',3);">
							<i class="icon-chevron-right"></i> 等待受理的问题
						</a>
					</li>
					<li  class="manger_admin_nav4">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',4);">
							<i class="icon-chevron-right"></i> 正在维修的问题
						</a>
					</li>
					<li  class="manger_admin_nav5">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',5);">
							<i class="icon-chevron-right"></i> 等待评价的问题
						</a>
					</li>
					<li  class="manger_admin_nav6">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',6);">
							<i class="icon-chevron-right"></i> 已完成的问题
						</a>
					</li>
					<li  class="manger_admin_nav7">
						<a href="javascript:void(0);" onclick="getHtml('nav_admin',7);">
							<i class="icon-chevron-right"></i> 审核未通过的问题
						</a>
					</li>
				</ul>
			</div>
			<div class="span7 mini-layout">
				
			</div>
		</div>
	</div>
</div>
<script src="js/mangerAdmin.js"></script>
<script>

function remove_active(){
	$(".content .row ul.nav li.active").removeClass("active");
}

function setUrl(name,state){
	var _state = {title:'',url:window.location.href.split("?")[0]};

    history.pushState(_state,'','?name='+name+'&state='+state);	
}

function ajax_fun(name,state){

	setUrl(name,state);
	
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

<div id="addevent"  class="modal hide fade">
	<div class="modal-header" style="text-align: center;cursor: move;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3></h3>
	</div>
	<div class="modal-body">
	    <p>
			<div id="addevent_div_name" style="display:none;">
				<span>分类名称: </span>
				<input id="addevent_name" type="text" placeholder="分类名称"  class="longtext" >
			</div>
			
			<div id="addevent_div_phone" style="display:none;">
				<span>电话号码: </span>
				<input id="addevent_phone" type="text" placeholder="电话号码"  class="longtext" >
			</div>
		</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true" >取消</button>
		<button class="btn btn-primary" onclick="">确认</button>
	</div>
</div>

<?php include_once('inc/footer.inc.php'); ?>
<?php include_once('inc/end.php'); ?>
