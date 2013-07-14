<div class="nav-top">
	<ul>
		
		<li class="nav0"><a href='.'><span>网站首页</span></a></li>
		<li class="nav1"><a href='suggest.php'><span>反馈问题</span></a></li>
		<li class="nav2"><a href='suggestList.php'><span>反馈记录</span></a></li>
	   
	<?php if($messagefkLev == 3) {?>
		<li class="nav6"><a href='mangerAdmin.php'><span>管理</span></a></li>
	<?php }else if($messagefkLev == 2){?>
		<li class="nav6"><a href='mangerFix.php'  ><span>管理</span></a></li>
	<?php }?>
	   
	<?php if(strcmp($messagefkEmail,"") == 0) {?>
		 <li class="nav4"><a href='login.php'><span>我要登陆</span></a></li>
	<?php } else {?>
		<li class="nav5"><a href='logout.php'><span>离开一会</span></a></li>
		<li class="nav7 info"><a href='javascript:void(0);'><span><?php echo "$messagefkEmail";?></span></a></li>
	<?php }?>
	</ul>
</div>
