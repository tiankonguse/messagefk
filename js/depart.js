	function click_add_depart(){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("添加分类");
		$("#addevent .modal-footer button.btn-primary").attr("onclick","add_depart();");
		$('#addevent').modal();
		return false;
	}
	
	function add_depart(){
		var $name = $("#addevent_name").val();
		
		if($name == ""){
			showMessage("你有空缺的表单项目没有完成！");
		}else{
			$.post("inc/manger.php?state=3",{
				name:$name
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=nav&state=1";},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		}
		
		return false;
	}
	
	function click_update_depart(id, name){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("修改分类名称[" + name + "]为:");
		$("#addevent .modal-footer button.btn-primary").attr("onclick","update_depart(" + id + ");");
		$('#addevent').modal();
		return false;
	}
	
	function update_depart($id){
		var $name = $("#addevent_name").val();
		
		if($name == ""){
			showMessage("你有空缺的表单项目没有完成！");
		}else{
			$.post("inc/manger.php?state=4",{
				id:$id,
				name:$name
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=nav&state=1";},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		}
		
		return false;
	}
	
	function click_delete_depart(id, name){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("删除下面的分类吗？");
		$("#addevent_name").val(name);
		$("#addevent .modal-footer button.btn-primary").attr("onclick","delete_depart(" + id + ");");
		$('#addevent').modal();
		return false;
	}
	
	function delete_depart($id){
		$.post("inc/manger.php?state=5",{
				id:$id
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=nav&state=1";},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		
		return false;
	}