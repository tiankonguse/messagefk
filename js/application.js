$(document).ready(function () {
	$("#iframe").ready(function(){
//		console.log("--");
		var change_iframe_height = function(){
			var $iframe =  $("#iframe");
			var newheight =$iframe.contents().find("body").height();
			var oldheight = $iframe.css("height");
			oldheight = oldheight.substr(0,oldheight.length-2);
			newheight = parseInt(newheight);
			oldheight = parseInt(oldheight);
			
				//console.log("---newheight="+(newheight));
				//console.log("---oldheight="+(oldheight ));
			if(newheight > 500){
				if(newheight > (oldheight + 50) || (newheight + 50) < oldheight){
					$iframe.css("height",newheight+"px");
				}				
			}
			setTimeout(change_iframe_height,1000);
			
		};
		change_iframe_height();	
		
	});	
});