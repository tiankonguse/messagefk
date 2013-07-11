$(function(){
	
	//title
	var title_check = function () {
		var title = $("#title").val();
		if (title.length < 1 || title.length > 70) {
			$('#_txt_title').removeClass("ok");
			$('#_txt_title').addClass("err");
			$('#_txt_title').html("<i class='margin-left2'>&nbsp;</i>标题格式不正确(由5-30个字符组成)");
			return false;
		}else {
			$('#_txt_title').removeClass("err");
			$('#_txt_title').addClass("ok");
			$('#_txt_title').html("<i class='margin-left2'>&nbsp;&nbsp;</i>");
			return true;
		}
		
	};

	//depart
	var array_depart;
	
	var depart_check = function () {
		var  $_txt_depart_id = $("#_txt_depart_id");
		var  $block_id = $("#block_id");
		var depart = $("#depart_id").val();
		
		 console.log("depart="+depart);
		if (depart == 0) {
			$_txt_depart_id.removeClass("ok");
			$_txt_depart_id.addClass("err");
			$_txt_depart_id.html("<i class='margin-left2'>&nbsp;</i>请选择类型！");
			
			$block_id.html("<option value='0'>请选择小类型</option>");
			$block_id.val("0");
			block_check();
			
			return false;
		}else {
			$_txt_depart_id.removeClass("err");
			$_txt_depart_id.addClass("ok");
			$_txt_depart_id.html("<i class='margin-left2'>&nbsp;</i>");
			
			console.log("-->block="+array_depart[depart]["block"]);
			$block_id.html(array_depart[depart]["block"]);
			$block_id.val("0");
			block_check();
			
			return true;
		}
	}
	
	var _depart_check = function () {
		return $("#depart_id").val() != 0;
	};
	
	
	//block
	var block_check = function () {
		
		var  $_txt_block_id = $("#_txt_block_id");
		var block = $("#block_id").val();
		if (block == 0) {
			$_txt_block_id.removeClass("ok");
			$_txt_block_id.addClass("err");
			$_txt_block_id.html("<i class='margin-left2'>&nbsp;</i>请选择小类型！");
			return false;
		}else {
			$_txt_block_id.removeClass("err");
			$_txt_block_id.addClass("ok");
			$_txt_block_id.html("<i class='margin-left2'>&nbsp;</i>");
			return true;
		}
	}

	//name
	var name_check = function () {
		var name = $("#name").val();
		if (name.length < 2 || name.length>10) {
			$('#_txt_name').removeClass("ok");
			$('#_txt_name').addClass("err");
			$('#_txt_name').html("<i class='margin-left2'>&nbsp;</i>姓名格式不正确！");
			return false;
		} else {
			$('#_txt_name').removeClass("err");
			$('#_txt_name').addClass("ok");
			$('#_txt_name').html("<i class='margin-left2'>&nbsp;</i>");
			return true;
		}
	}
	
	function isEmail(str){
	       var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	       return reg.test(str);
	}
	
	//email
	var email_check = function () {
		var email = $("#email").val();
		if (!isEmail(email)) {
			$('#_txt_email').removeClass("ok");
			$('#_txt_email').addClass("err");
			$('#_txt_email').html("<i class='margin-left2'>&nbsp;</i>邮箱格式不正确！");
			return false;
		} else {
			$('#_txt_email').removeClass("err");
			$('#_txt_email').addClass("ok");
			$('#_txt_email').html("<i class='margin-left2'>&nbsp;</i>");
			return true;
		}
	}

	//phone
	function phone_check() {
		var phone = $("#phone").val();
		if (phone.length == 11 && (/^[0-9]{11}$/.test(phone))) {
			$('#_txt_phone').removeClass("err");
			$('#_txt_phone').addClass("ok");
			$('#_txt_phone').html("<i class='margin-left2'>&nbsp;</i>");
			return true;
		} else {
			$('#_txt_phone').removeClass("ok");
			$('#_txt_phone').addClass("err");
			$('#_txt_phone').html("<i class='margin-left2'>&nbsp;</i>手机格式不正确！");
			return false;
		}
	}


	
	$("#submit").click(function(){
		console.log("begin check");
		 if(!title_check() || !_depart_check()|| !block_check()|| !name_check()|| !email_check() || !phone_check()){
			 showMessage("表单填写不正确，加星的为必填");
			 return false;
		 }
		 
		var $content = $("#content").val();
		if($content == ""){
			showMessage("问题描述不能为空");
			return false;
		}
		
		
		
		var $title = $("#title").val();
		var $depart_id = $("#depart_id").val();
		var $block_id = $("#block_id").val();
		var $name = $("#name").val();
		var $email = $("#email").val();
		var $phone = $("#phone").val();
		
		$.post("inc/manger.php?state=10",{
			title:$title,
			depart_id:$depart_id,
			block_id:$block_id,
			name:$name,
			email:$email,
			phone:$phone,
			content:$content
		},function(d){
			if(d.code==0){
				showMessage(d.message,function(){window.location = "login.php";},4000);
			}else{
				showMessage(d.message);
			}
		},"json");
		
		
		return false;
	});
	
	$(document).ready(function () {
		$.getJSON("inc/manger.php?state=9",function(data){
			var $depart_id = $("#depart_id");
			array_depart = data;
			$.each(data,function(index,array){
                var option = "<option value='"+array['depart_id']+"' >"+array['name']+"</option>";
                $depart_id.append(option);
            });
		});

		
		//标题
		$('#title').blur(function () {title_check();});
		$('#depart_id').change(function () {depart_check();});
		$('#block_id').change(function () {block_check();});
		$('#name').blur(function () {name_check();});
		$('#phone').blur(function () {phone_check();});
	});
	
});




