function clickPassCheck(problemId) {
	$.post("inc/manger.php?state=13", {
		id : problemId
	}, function(d) {
		if (d.code == 0) {
			$('#addevent').modal('hide');
			showMessage(d.message, function() {
				window.location = "mangerAdmin.php?name=nav_admin&state=3";
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
				window.location = "mangerAdmin.php?name=nav_admin&state=7";
			}, 4000);
		} else {
			showMessage(d.message);
		}
	}, "json");
}
