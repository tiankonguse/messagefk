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

function clickFinish(problemId) {
	var $chargeContent = $("#chargeContent").val();
	var $totalCharge = $("#totalCharge").val();
	var $fixProple = $("#fixProple").val();
	var $fixResult = $("#fixResult").val();

	if ($chargeContent == "" || $totalCharge == "" || $fixProple == ""
			|| $fixResult == "") {
		showMessage("红色部分不能为空");
		return false;
	}

	if (!isNumber($totalCharge)) {
		showMessage("金额必须整数数字");
		return false;
	}

	$.post("inc/manger.php?state=16", {
		id : problemId,
		chargeContent : $chargeContent,
		totalCharge : $totalCharge,
		fixProple : $fixProple,
		fixResult : $fixResult
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

	var $star = parseInt(parseInt($("#start-grade").css('width'))/26);	
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
