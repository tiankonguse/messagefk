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

function showHighcharts_column($container, title, xAxis, yTitle, data, subtitle, maxY) {
    $container
	    .highcharts({
		chart : {
		    type : 'column'
		},
		title : {
		    text : title
		},
		subtitle : {
		    text : subtitle
		},
		xAxis : {
		    categories : xAxis
		},
		yAxis : {
		    min : 0,
		    title : {
			text : yTitle
		    },
		    max:maxY
		},
		tooltip : {
		    headerFormat : '<span style="font-size:10px">{point.key}</span><table>',
		    pointFormat : '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'
			    + '<td style="padding:0"><b>{point.y:.1f} 分</b></td></tr>',
		    footerFormat : '</table>',
		    shared : true,
		    useHTML : true
		},
		plotOptions : {
		    column : {
			pointPadding : 0.2,
			borderWidth : 0
		    }
		},
		series : data
	    });
}

function showHighcharts_pie($container, title, typeText, data) {

    $container.highcharts({
	chart : {
	    plotBackgroundColor : null,
	    plotBorderWidth : null,
	    plotShadow : false
	},
	title : {
	    text : title
	},
	tooltip : {
	    pointFormat : '{series.name}: <b>{point.percentage:.1f}%</b>'
	},
	plotOptions : {
	    pie : {
		allowPointSelect : true,
		cursor : 'pointer',
		dataLabels : {
		    enabled : true,
		    color : '#000000',
		    connectorColor : '#000000',
		    format : '<b>{point.name}</b>: {point.percentage:.1f} %'
		},
		showInLegend : true
	    }
	},

	series : [ {
	    type : 'pie',
	    name : typeText,
	    data : data
	} ]
    });
}

function showHighcharts_line($container, title, xAxis, yTitle, data) {
    $container.highcharts({
	title : {
	    text : title,
	    x : -20
	// center
	},
	xAxis : {
	    categories : xAxis
	},
	yAxis : {
	    title : {
		text : yTitle
	    },
	    plotLines : [ {
		value : 0,
		width : 1,
		color : '#808080'
	    } ]
	},
	legend : {
	    layout : 'vertical',
	    align : 'right',
	    verticalAlign : 'middle',
	    borderWidth : 0
	},
	series : data
    });
}

function everyYearNumberOfRepairs(className) {
    var $container = $("." + className);

    $.post("inc/manger.php?state=18", {}, function(d) {
	if (d.code == 0) {
	    var obj = d.message;
	    var _data = obj.data;
	    var l = _data.length;
	    var H_data = [];
	    var data;
	    for ( var i = 0; i < l; i++) {
		H_data[i] = {
		    "name" : _data[i]["name"],
		    "data" : null
		};
		data = _data[i]["data"];
		for ( var j in data) {
		    data[j] = parseInt(data[j]);
		}
		H_data[i]["data"] = data;
	    }

	    showHighcharts_line($container, "各类别项目每年以及到目前位置的维修次数", obj.xAxis,
		    "个数", H_data);

	} else {
	    $container.html(d.message);
	}
    }, "json");
}

function proportionOfRepairs(className) {
    var $container = $("." + className);
    $.post("inc/manger.php?state=19", {}, function(d) {
	if (d.code == 0) {
	    var obj = d.message;
	    showHighcharts_pie($container, "各类别项目的维修次数比例", "维修次数", obj);
	} else {
	    $container.html(d.message);
	}
    }, "json");
}

function getProportionOfDepart(className, title, typeText, departName) {
    var $container = $("." + className);
    $.post("inc/manger.php?state=20", {
	departName : departName
    }, function(d) {
	console.log(d);
	if (d.code == 0) {
	    var obj = d.message;

	    showHighcharts_pie($container, title, typeText, obj);
	} else {
	    $container.html(d.message);
	}
    }, "json");
}

function AverageTimeOfRepairs(className) {
    var $container = $("." + className);
    $.post("inc/manger.php?state=21", {}, function(d) {
	if (d.code == 0) {
	    var obj = d.message;
	    var _data = obj.data;
	    var total = 0;
	    var l = _data.length;
	    var H_data = [];
	    var data;
	    for ( var i = 0; i < l; i++) {
		H_data[i] = {
		    "name" : _data[i]["name"],
		    "data" : null
		};
		data = _data[i]["data"];
		total += parseInt(_data[i]["total"]);
		for ( var j in data) {
		    data[j] = parseInt(data[j]);
		}
		H_data[i]["data"] = data;
	    }
	    showHighcharts_column($container, "各类别项目维修完成的平均用时", obj.xAxis,
		    "平均用时", H_data, "总用时：" + total + "分");
	} else {
	    $container.html(d.message);
	}
    }, "json");
}

function AverageSatisfactionRateOfRepairs(className) {
    var $container = $("." + className);
    $.post("inc/manger.php?state=22", {}, function(d) {
	if (d.code == 0) {
	    var obj = d.message;

	    var _data = obj.data;
	    var total = 0;
	    var l = _data.length;
	    var H_data = [];
	    var data;
	    for ( var i = 0; i < l; i++) {
		H_data[i] = {
		    "name" : _data[i]["name"],
		    "data" : null
		};
		data = _data[i]["data"];
		total += parseInt(_data[i]["total"]);
		for ( var j in data) {
		    data[j] = parseInt(data[j]);
		}
		H_data[i]["data"] = data;
	    }
	    showHighcharts_column($container, "各类别项目的平均满意率", obj.xAxis,
		    "平均满意率(0～100)", H_data, "总满意率：" + total + "分", 100);
	} else {
	    $container.html(d.message);
	}
    }, "json");
}
