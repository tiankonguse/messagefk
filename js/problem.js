function clickPassCheck(problemId) {
	$.post("inc/manger.php?state=13", {
		id : problemId
	}, function(d) {
		if (d.code == 0) {
			$('#addevent').modal('hide');
			showMessage(d.message, function() {
				window.location = "problem.php?id=" + problemId;
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");
}

function clickNotPassCheck(problemId) {
	$.post("inc/manger.php?state=14", {
		id : problemId
	}, function(d) {
		if (d.code == 0) {
			$('#addevent').modal('hide');
			showMessage(d.message, function() {
				window.location = "problem.php?id=" + problemId;
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");
}

function clickAccept(problemId) {

	$.post("inc/manger.php?state=15", {
		id : problemId
	}, function(d) {
		if (d.code == 0) {
			$('#addevent').modal('hide');
			showMessage(d.message, function() {
				window.location = "problem.php?id=" + problemId;
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");
}

function isNumber(str) {
	var reg = /^[0-9]+$/;
	return reg.test(str);
}

function isPhone(str) {
	var reg = /^[0-9]+$/;
	return reg.test(str);
}

function clickFinish(problemId) {
	var problemReason = $("#problemReason").val(); // 问题原因
	var totalCharge = parseFloat($(".all-bill").text()); //金额
	var charge = getCharge(); //金额列表
	charge = "write by tiankonguse" + charge;
	var fixPeople = $("#fixProple").val();  //维修人
	var fixPhone = $("#fixphone").val();  //维修人电话
	var fixResult = $("#fixResult").val(); //维修结果
	
	if (problemReason == "" || fixPeople == ""
			|| fixResult == "") {
		showMessage("红色部分不能为空");
		return false;
	}

	if (!isPhone(fixPhone)) {
		showMessage("维修人电话有误");
		return false;
	}

	$.post("inc/manger.php?state=16", {
		id : problemId,
		problemReason : problemReason,
		totalCharge : totalCharge,
		charge : charge,
		fixPhone : fixPhone,
		fixPeople : fixPeople,
		fixResult : fixResult
	}, function(d) {
		if (d.code == 0) {
			showMessage(d.message, function() {
				window.location = "problem.php?id=" + problemId;
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");

}

function clickOver(problemId) {

	var $star = parseInt(parseInt($("#start-grade").css('width')) / 26);
	var $starConetnt = $("#starContent").val();
	if ($starConetnt == "") {
		showMessage("请填写评价内容");
		return false;
	}

	$.post("inc/manger.php?state=17", {
		id : problemId,
		starConetnt : $starConetnt,
		star : $star
	}, function(d) {
		if (d.code == 0) {
			showMessage(d.message, function() {
				window.location = "problem.php?id=" + problemId;
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");
}

function preview(problemId) {
	var bdhtml = $("body")[0].innerHTML;// 获取当前页的html代码
	var prnhtml = $(".mini-layout.content-inner")[0].innerHTML; // 从开始代码向后取html

	window.document.body.innerHTML = prnhtml;
	setTimeout(function(){
		window.print();
		setTimeout(function(){
			window.document.body.innerHTML = bdhtml;
		},2000);
		clickAccept(problemId);
	},1000);

	
}

function getSum() {
	var totalCharge = 0;
	var $all_bill = $(".all-bill");
	$(".bill tbody tr").each(function(i) {
		var that = $(this);
		var td = that.find("input");
		var count = parseInt(td[1].value) || 0;

		var price = parseFloat(td[2].value) || 0;

		var $cost = td[3];
		$cost.value = (price * count).toFixed(2);;
		totalCharge += parseFloat($cost.value);
	});
	totalCharge = totalCharge.toFixed(2);
//	totalCharge = totalCharge.toFixed(2);
	$all_bill.text(totalCharge + "元");

}

function getCharge() {
	var charge = [];
	var num = 0;
	$(".bill tbody tr").each(function(i) {
		var that = $(this);
		var td = that.find("input");
		var name = td[0].value || "";
		var count = parseInt(td[1].value) || 0;
		var price = parseFloat(td[2].value) || 0;
		var cost = (price * count).toFixed(2);

		if (name && count && price && cost) {
			charge[num] = {
				name : name,
				count : count,
				price : price,
				cost : cost
			};
			num++;
		}

	});
	return JSON.stringify(charge);
}

function checkSum() {
	var totalCharge = 0;
	var $all_bill = $(".all-bill");
	$(".bill tbody tr").each(function(i) {
		var that = $(this);
		var td = that.find("input");
		var count = parseInt(td[1].value) || 0;
		td[1].value = count;

		var price = parseFloat(td[2].value) || 0;
		td[2].value = price;

		var $cost = td[3];
		$cost.value = (price * count).toFixed(2);
		totalCharge += parseFloat($cost.value);
	});
	totalCharge = totalCharge.toFixed(2);
	$all_bill.text(totalCharge + "元");
}

$(document).ready(function() {
	$(".bill input").keyup(function() {
		getSum();
	});
	$(".bill input").blur(function() {
		checkSum();
	});

});
