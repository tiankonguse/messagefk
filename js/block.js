	function click_add_block(){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("添加子分类");
		$("#addevent .modal-footer button.btn-primary").attr("onclick","add_block();");
		$('#addevent').modal();
		return false;
	}
	
	function add_block(){
		var $name = $("#addevent_name").val();
		if($name == ""){
			showMessage("你有空缺的表单项目没有完成！");
		}else{
			$.post("inc/manger.php?state=6",{
				name:$name,
				depart_id:$depart_id
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=depart&state="+$depart_id;},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		}
		
		return false;
	}
	
	function click_update_block(id, name){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("修改子分类名称[" + name + "]为:");
		$("#addevent .modal-footer button.btn-primary").attr("onclick","update_block(" + id + ");");
		$('#addevent').modal();
		return false;
	}
	
	function update_block($id){
		var $name = $("#addevent_name").val();
		
		if($name == ""){
			showMessage("你有空缺的表单项目没有完成！");
		}else{
			$.post("inc/manger.php?state=7",{
				id:$id,
				name:$name
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=depart&state="+$depart_id;},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		}
		
		return false;
	}
	
	function click_delete_block(id, name){
		$("#addevent_name").val("");
		$("#addevent .modal-header h3").html("删除下面的子分类吗？");
		$("#addevent_name").val(name);
		$("#addevent .modal-footer button.btn-primary").attr("onclick","delete_block(" + id + ");");
		$('#addevent').modal();
		return false;
	}
	
	function delete_block($id){
		$.post("inc/manger.function.php?state=1",{
				id:$id
			},function(d){
				if(d.code==0){
					$('#addevent').modal('hide');
					showMessage(d.message,function(){window.location = "manger.php?name=depart&state="+$depart_id;},4000);
				}else{
					showMessage(d.message);
				}
			},"json");
		
		return false;
	}