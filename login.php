<?php
session_start();
require_once("inc/init.php");
$title = "信息反馈系统登陆页面";
include_once('inc/header.inc.php');

$messagefk_id    = $_SESSION['messagefk_id'];
$messagefk_email = $_SESSION['messagefk_email'];
$messagefk_lev   = $_SESSION['messagefk_lev'];
if(strcmp($messagefk_lev, "") == 0){
	$messagefk_lev = 0;
}else{
	header('Location:index.php');
}


$type  =  4;
?>
<div class="wrap">
<?php include_once('inc/top.inc.php'); ?>
<?php include_once('inc/nav.inc.php'); ?>
	<div class="content">
		<div class="loginbox">
		    <div class="login-hint-line">
		        <span class="login-hint-title">用户登录</span>
		    </div>
			<form class="form-horizontal form-signin" action="" method="post">
				<div class="control-group">
					<label class="control-label"  for="inputEmail">邮箱</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-envelope"></i></span>
							<input class="span4" name="signin_email" type="text" placeholder="邮箱">
							<span class="add_infomation"><b>友情提示</b>：请用数字校园统一认证邮箱</span>  
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  for="inputPassword">密码</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span>
							<input type="password" name="signin_password" placeholder="密码"  class="span4">
						</div>
						
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-large btn-primary" type="submit">登陆</button>
						<button type="button" id="register" class="btn btn-large btn-success" >注册</button>
					</div>
				</div>
			  </form>
			  
		</div>
	</div>

 
<div id="addevent"  class="modal hide fade">
	<div class="form-horizontal">
		<div class="modal-header" style="text-align: center;cursor: move;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>注册</h3>
		</div>
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label"  for="inputEmail">邮箱</label>
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input class="span3" id="email" type="text" placeholder="邮箱">
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  for="inputPassword">密码</label>
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input type="password" id="password1" placeholder="密码"  class="span3">
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  for="inputPassword">确认密码</label>
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input type="password" id="password2" placeholder="确认密码" class="span3">
					</div>
				</div>
			</div>
  		</div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true" >取消</button>
		    <button class="btn btn-primary" onclick="addNewUser();return false;">确认</button>
		  </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
	$("#register").click(function(){
		$("#email").val("");
		$("#password1").val("");
		$("#password2").val("");
		$('#addevent').modal();
		return false;
	});


	<?php 
		if(strcmp($_GET["messageCode"],"1") == 0){
			echo "showMessage('请先登录在操作！');";
		}
	?>


	$("form").submit(function(){
		var I = this;
		if(this.signin_email.value == "" || this.signin_password.value == ""){
			showMessage("你有空缺的表单项目没有完成！");
		}else{
			$.post("inc/manger.php?state=2",{
				email:I.signin_email.value,
				password:I.signin_password.value
			},function(d){
				if(d.code==0){
					showMessage(d.message,function(){window.location = "index.php";},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		}
		return false;
	});
});
function addNewUser(){
	var $email = $("#email").val();
	var $password1 = $("#password1").val();
	var $password2 = $("#password2").val();
	
	if(!$email || !$password1 || !$password2){
		showMessage("你有空缺的表单没有完成！");
		return false;
	}
	
	if($password1 != $password2){
		showMessage("输入的两次密码不同");
		return false;
	}
	
	$.post("inc/manger.php?state=1",{
		email:$email,
		password1:$password1,
		password2:$password2
	},function(d){
		if(d.code==0){
			showMessage(d.message);
			
			$('#addevent').modal('hide');
			showMessage("注册用户成功");
		}else{
			showMessage(d.message);
		}
	},"json");
	
	return false;
}
</script>
<?php include_once('inc/footer.inc.php'); ?>
<?php include_once('inc/end.php'); ?>
