function init_addevent(param) {
    // set title
    $("#addevent .modal-header h3").html(param["title"]);

    // set body
    var name = [ "name", "phone" ];

    for ( var i = 0; i < 2; i++) {
	$("#addevent_div_" + name[i]).css("display",
		param["body"][i]["display"]);
	$("#addevent_div_" + name[i] + " span").html(param["body"][i]["name"]);
	$("#addevent_" + name[i]).val(param["body"][i]["val"]);
	$("#addevent_" + name[i]).attr("placeholder",
		param["body"][i]["placeholder"]);
	if (param["body"][i]["disabled"]) {
	    $("#addevent_" + name[i]).attr("disabled", "");
	} else {
	    $("#addevent_" + name[i]).removeAttr("disabled");
	}
    }

    // set footer
    $("#addevent .modal-footer button.btn-primary").attr("onclick",
	    param["footer"]);
}

function click_add_depart() {
    init_addevent({
	title : "添加分类",
	body : [ {
	    display : "block",
	    name : "分类名称 : ",
	    val : "",
	    disabled : false,
	    placeholder : "分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "add_depart();"
    });
    $('#addevent').modal();
    return false;
}

function add_depart() {
    var $name = $("#addevent_name").val();

    if ($name == "") {
	showMessage("你有空缺的表单项目没有完成！");
    } else {
	$.post("inc/manger.php?state=3", {
	    name : $name
	}, function(d) {
	    if (d.code == 0) {
		$('#addevent').modal('hide');
		showMessage(d.message, function() {
		    window.location = "mangerAdmin.php?name=nav_admin&state=1";
		}, 4000);
	    } else {
		showMessage(d.message);
	    }
	}, "json");
    }
    return false;
}

function click_update_depart(id, name) {

    init_addevent({
	title : "修改分类名称[" + name + "]为:",
	body : [ {
	    display : "block",
	    name : "分类名称 : ",
	    val : "",
	    disabled : false,
	    placeholder : "分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "update_depart(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function update_depart($id) {
    var $name = $("#addevent_name").val();

    if ($name == "") {
	showMessage("你有空缺的表单项目没有完成！");
    } else {
	$.post("inc/manger.php?state=4", {
	    id : $id,
	    name : $name
	}, function(d) {
	    if (d.code == 0) {
		$('#addevent').modal('hide');
		showMessage(d.message, function() {
		    window.location = "mangerAdmin.php?name=nav_admin&state=1";
		}, 4000);
	    } else {
		showMessage(d.message);
	    }
	}, "json");
    }

    return false;
}

function click_delete_depart(id, name) {

    init_addevent({
	title : "删除下面的分类吗？",
	body : [ {
	    display : "block",
	    name : "分类名称 : ",
	    val : name,
	    disabled : true,
	    placeholder : "分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "delete_depart(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function delete_depart($id) {

    $.post("inc/manger.php?state=5", {
	id : $id
    }, function(d) {
	if (d.code == 0) {
	    $('#addevent').modal('hide');
	    showMessage(d.message, function() {
		window.location = "mangerAdmin.php?name=nav_admin&state=1";
	    }, 4000);
	} else {
	    showMessage(d.message);
	}
    }, "json");

    return false;
}

function click_update_depart_admin(id, name) {

    init_addevent({
	title : "修改分类[" + name + "]的管理员:",
	body : [ {
	    display : "block",
	    name : "管理员的邮箱：",
	    val : "",
	    disabled : false,
	    placeholder : "请使用师大邮箱"
	}, {
	    display : "block",
	    name : "管理员的手机：",
	    val : "",
	    disabled : false,
	    placeholder : "管理员手机的手机号码"
	} ],
	footer : "update_depart_admin(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function update_depart_admin($id) {
    var $name = $("#addevent_name").val();
    var $phone = $("#addevent_phone").val();

    if ($name == "") {
	showMessage("你有空缺的表单项目没有完成！");
    } else {
	$.post("inc/manger.php?state=11", {
	    email : $name,
	    phone : $phone,
	    id : $id
	}, function(d) {
	    if (d.code == 0) {
		$('#addevent').modal('hide');
		showMessage(d.message, function() {
		    window.location = "mangerAdmin.php?name=nav_admin&state=1";
		}, 4000);
	    } else {
		showMessage(d.message);
	    }
	}, "json");
    }

    return false;
}

function click_delete_depart_admin(id, name, userEmail) {

    init_addevent({
	title : "确认你要删除[" + name + "]的管理员吗？",
	body : [ {
	    display : "block",
	    name : "管理员的邮箱：",
	    val : userEmail,
	    disabled : true,
	    placeholder : "请使用师大邮箱"
	}, {
	    display : "none",
	    name : "管理员的手机：",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "delete_depart_admin(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function delete_depart_admin(id) {
    $.post("inc/manger.php?state=12", {
	id : id
    }, function(d) {
	if (d.code == 0) {
	    $('#addevent').modal('hide');
	    showMessage(d.message, function() {
		window.location = "mangerAdmin.php?name=nav_admin&state=1";
	    }, 4000);
	} else {
	    showMessage(d.message);
	}
    }, "json");

    return false;
}

function click_add_block() {

    init_addevent({
	title : "添加子分类",
	body : [ {
	    display : "block",
	    name : "子分类名称 : ",
	    val : "",
	    disabled : false,
	    placeholder : "子分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "add_block();"
    });

    $('#addevent').modal();
    return false;
}

function add_block() {
    var $name = $("#addevent_name").val();
    if ($name == "") {
	showMessage("你有空缺的表单项目没有完成！");
    } else {
	$.post("inc/manger.php?state=6", {
	    name : $name,
	    depart_id : $depart_id
	}, function(d) {
	    if (d.code == 0) {
		$('#addevent').modal('hide');
		showMessage(d.message, function() {
		    window.location = "mangerAdmin.php?name=depart&state="
			    + $depart_id;
		}, 4000);
	    } else {
		showMessage(d.message);
	    }
	}, "json");
    }

    return false;
}

function click_update_block(id, name) {

    init_addevent({
	title : "修改子分类名称[" + name + "]为:",
	body : [ {
	    display : "block",
	    name : "子分类名称 : ",
	    val : "",
	    disabled : false,
	    placeholder : "子分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "update_block(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function update_block($id) {
    var $name = $("#addevent_name").val();

    if ($name == "") {
	showMessage("你有空缺的表单项目没有完成！");
    } else {
	$.post("inc/manger.php?state=7", {
	    id : $id,
	    name : $name
	}, function(d) {
	    if (d.code == 0) {
		$('#addevent').modal('hide');
		showMessage(d.message, function() {
		    window.location = "mangerAdmin.php?name=depart&state="
			    + $depart_id;
		}, 4000);
	    } else {
		showMessage(d.message);
	    }
	}, "json");
    }

    return false;
}

function click_delete_block(id, name) {

    init_addevent({
	title : "删除下面的子分类吗？",
	body : [ {
	    display : "block",
	    name : "子分类名称 : ",
	    val : name,
	    disabled : true,
	    placeholder : "子分类名称"
	}, {
	    display : "none",
	    name : "",
	    val : "",
	    disabled : false,
	    placeholder : ""
	} ],
	footer : "delete_block(" + id + ");"
    });

    $('#addevent').modal();
    return false;
}

function delete_block($id) {
    $.post("inc/manger.php?state=8", {
	id : $id
    }, function(d) {
	if (d.code == 0) {
	    $('#addevent').modal('hide');
	    showMessage(d.message, function() {
		window.location = "mangerAdmin.php?name=depart&state="
			+ $depart_id;
	    }, 4000);
	} else {
	    showMessage(d.message);
	}
    }, "json");

    return false;
}

function showHighcharts($container, title, xAxis, yTitle, data){
    $container.highcharts({
        title: {
            text: title,
            x: -20 //center
        },
        xAxis: {
            categories: xAxis
        },
        yAxis: {
            title: {
                text: yTitle
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: data
    });
}


function everyYearNumberOfRepairs(className){
    $container = $("."+className);
    $.post("inc/manger.php?state=18", {
    }, function(d) {
	if (d.code == 0) {
	    $container.html(d.message);
	} else {
	    $container.html(d.message);
	}
    }, "json");
}

