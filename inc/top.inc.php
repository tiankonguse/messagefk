<div id="alter"  class="alert alert-block" style="display:none">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Warning!</h4>
	<div id="ie_id"> </div>
	你的浏览器版本太低，请升级浏览器版本。
	<br>
	ie浏览器建议升级到最新版本。
</div>
<script>
$(document).ready(function(){
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	if (window.ActiveXObject)Sys.ie = ua.match(/msie ([\d.]+)/)[1];
	if(Sys.ie && Sys.ie<=7.0) {
		//$("#ie_id").html(Sys.ie);
		$("#alter").css("display","block");
	}
});
</script>

<div class="top">
	<div class="logo"><img src="img/top.png" height="75" width="1000"></div>
</div>