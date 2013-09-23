<?php
session_start();
require_once("inc/init.php");
$title = "信息反馈系统管理页面";
include_once('inc/header.inc.php');

$messagefkId    = isset($_SESSION['messagefkId']) ? $_SESSION['messagefkId'] : "";
$messagefkEmail    = isset($_SESSION['messagefkEmail']) ? $_SESSION['messagefkEmail'] : "";
$messagefkLev    = isset($_SESSION['messagefkLev']) ? $_SESSION['messagefkLev'] : "";

if(strcmp($messagefkLev, LEV_FIX) != 0){
	header('Location:login.php');
}

$name    = isset($_GET['name']) ? $_GET['name'] : "";
$state    = isset($_GET['state']) ? $_GET['state'] : "";

if(strcmp($name,"") == 0){
	$name = "nav_fix";
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
					<li class="manger_fix_nav1 active">
						<a href="javascript:void(0);" onclick="getHtml('nav_fix',1);">
							<i class="icon-chevron-right"></i> 全部问题
						</a>
					</li>
					<li  class="manger_fix_nav2">
						<a href="javascript:void(0);" onclick="getHtml('nav_fix',2);">
							<i class="icon-chevron-right"></i> 等待受理的问题
						</a>
					</li>
					<li  class="manger_fix_nav3">
						<a href="javascript:void(0);" onclick="getHtml('nav_fix',3);">
							<i class="icon-chevron-right"></i> 正在维修的问题
						</a>
					</li>
				</ul>
			</div>
			<div class="span7 mini-layout">
				
			</div>
		</div>
	</div>
</div>

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
	if(name == 'nav_fix'){
		remove_active();
		$(".manger_fix_nav"+state).addClass("active");
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
