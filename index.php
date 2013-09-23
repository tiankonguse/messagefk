<?php
session_start();
require_once("inc/init.php");
require_once('inc/function.php');
$title = "信息反馈系统";
require_once('inc/header.inc.php');

$messagefkId    = isset($_SESSION['messagefkId']) ? $_SESSION['messagefkId'] : "";
$_SESSION['messagefkId'] = $messagefkId;
$messagefkEmail    = isset($_SESSION['messagefkEmail']) ? $_SESSION['messagefkEmail'] : "";
$_SESSION['messagefkEmail'] = $messagefkEmail;
$messagefkLev    = isset($_SESSION['messagefkLev']) ? $_SESSION['messagefkLev'] : "";
$_SESSION['messagefkLev'] = $messagefkLev;

if(strcmp($messagefkLev, "") == 0){
	$messagefkLev = 0;
}

$name    = isset($_GET['name']) ? $_GET['name'] : "";
$state    = isset($_GET['state']) ? $_GET['state'] : "";


if(strcmp($name,"") == 0){
	$name = "nav_index";
	$state = 1;
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
					<li class="index_nav1 active">
						<a href="javascript:void(0);" onclick="getHtml('nav_index',1);">
							<i class="icon-chevron-right"></i> 全部
						</a>
					</li>
					<li  class="index_nav2">
						<a href="javascript:void(0);" onclick="getHtml('nav_index',2);">
							<i class="icon-chevron-right"></i> 等待受理中
						</a>
					</li>
					<li  class="index_nav3">
						<a href="javascript:void(0);" onclick="getHtml('nav_index',3);">
							<i class="icon-chevron-right"></i> 正在维修中
						</a>
					</li>
					<li  class="index_nav4">
						<a href="javascript:void(0);" onclick="getHtml('nav_index',4);">
							<i class="icon-chevron-right"></i> 等待评价中
						</a>
					</li>
					<li  class="index_nav5">
						<a href="javascript:void(0);" onclick="getHtml('nav_index',5);">
							<i class="icon-chevron-right"></i> 完成的
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
	if(name == 'nav_index'){
		remove_active();
		$(".index_nav"+state).addClass("active");
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

