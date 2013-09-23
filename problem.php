<?php
session_start();
require("inc/init.php");
$title = "信息反馈系统提交問題";
require('inc/header.inc.php');
require('inc/function.php');

$messagefkId    = isset($_SESSION['messagefkId']) ? $_SESSION['messagefkId'] : "";
$messagefkEmail    = isset($_SESSION['messagefkEmail']) ? $_SESSION['messagefkEmail'] : "";
$messagefkLev    = isset($_SESSION['messagefkLev']) ? $_SESSION['messagefkLev'] : "";


if(!isset($_GET["id"])){
	header('Location:index.php');
}

$id = intval($_GET["id"]);

if($id <= 0){
	header('Location:index.php');
}

$sql = "SELECT * FROM `problem` WHERE `id` = '$id'";
$result = mysql_query($sql ,$conn);

if(!$row=mysql_fetch_array($result)){
	header('Location:index.php');
}

$problemId = $id;

$userId = $row['user_id'];
$userEmail = getUserEmail($userId);
$userName = $row['realName'];
$phone = $row['phone'];
$star = intval($row['star']);

$title = $row['title'];
$content = $row['content'];
$starContent =  $row['starContent'];

$departId = $row['depart_id'];
$departName = getDepartName($departId);
$departMangerId = getDepartMangerId($departId);


$blockId = $row['block_id'];
$blockName = getBlocktName($blockId);

$phone = $row['phone'];

$state = $row['state'];

$suggestTime = "";
$passTime = "";
$acceptTime = "";
$finishTime = "";
$overTime = "";
$totalTime = $row['total_time'];
$fixEmail = "";
$chargeContent = $row['chargeContent'];
$result = $row['result'];
$totalCharge = $row['totalCharge'];
$fixProple = $row['fixProple'];

$suggestTime = getStateTime($problemId,1);

if($state != PRO_NOT_PASS){
	if($state >= PRO_PASS){
		$passTime = getStateTime($problemId, PRO_PASS);
		$passTime = date("Y-m-d h:i:s",$passTime);
	}
	if($state >= PRO_ACCEPT){
		$acceptTime = getStateTime($problemId, PRO_ACCEPT);
		$acceptTime = date("Y-m-d h:i:s",$acceptTime);
		
		$fixEmail = getUserEmail($departMangerId);
	}
	
	if($state >= PRO_FINISH){
		$finishTime = getStateTime($problemId, PRO_FINISH);
		$finishTime = date("Y-m-d h:i:s",$finishTime);
		
		$tmp = $totalTime;
		$totalTime = "";
		
		$tmp = intval($tmp/1000);
		if($tmp%60 == 0){
			$totalTime = "0分".$totalTime;
		}else{
			$totalTime = ($tmp%60)."分".$totalTime;
		}
		
		$tmp = intval($tmp/60);
		if($tmp%24 == 0){
			$totalTime = "0小时".$totalTime;
		}else{
			$totalTime = ($tmp%24)."小时".$totalTime;
		}
		
		$tmp = intval($tmp/24);
		if($tmp == 0){
			$totalTime = "0天".$totalTime;
		}else{
			$totalTime = $tmp."天".$totalTime ;
		}
	}
	
	if($state >= PRO_OVER){
		$overTime = getStateTime($problemId, PRO_OVER);
		$overTime = date("Y-m-d h:i:s",$overTime);
	}
	
	
}


$formId = date("Ymdhis",$suggestTime) . $problemId;

$suggestTime = date("Y-m-d h:i:s",$suggestTime);

$stateHtml = getStateHtml($state);

$fixClass = "red";
$type  =  2;
?>
<div class="wrap container">
<?php include_once('inc/top.inc.php'); ?>
<?php include_once('inc/nav.inc.php'); ?>
	<div class="content">
		<div class="page-header" style="text-align: center;">
			<h2>问题的具体信息</h2>
		</div>
		<div class="flowstep" id="J_Flowstep">
			<ol class="flowstep-4">
				<li class="step-first">
					<div class="step-down">
						<div class="step-name">提交问题</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li>
					<div
						class="<?php if($state != PRO_NOT_PASS && $state >=2){echo "step-down";}?>">
						<div class="step-name">审核通过</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div
						class="<?php if($state != PRO_NOT_PASS && $state >=3){echo "step-down";}?>">
						<div class="step-name">受理通过</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div
						class="<?php if($state != PRO_NOT_PASS && $state >=3){echo "step-down";}?>">
						<div class="step-name">正在維修中</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li>
					<div
						class="<?php if($state != PRO_NOT_PASS && $state >=4){echo "step-down";}?>">
						<div class="step-name">維修完成</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li class="step-last">
					<div
						class="<?php if($state != PRO_NOT_PASS && $state >=5){echo "step-down";}?>">
						<div class="step-name">评价完成</div>
						<div class="step-no"></div>
					</div>
				</li>
			</ol>
		</div>
		<div class="mini-layout content-inner">
			<table class="table table-striped table-bordered table-condensed">
				<tbody>
					<tr>
						<td colspan="6" class="problem-table-head">申报信息</td>
					</tr>
					<tr>
						<td>单据号:</td>
						<td><?php echo $formId;?></td>
						<td>状态：</td>
						<td><?php echo $stateHtml;?></td>
						<td>申报时间：</td>
						<td><?php echo $suggestTime;?></td>
					</tr>
					<tr>
						<td>申报人：</td>
						<td><?php echo $userName;?></td>
						<td>申报电话：</td>
						<td><?php echo $phone;?></td>
						<td>审核时间：</td>
						<td><?php echo $passTime;?></td>
					</tr>
					<tr>
						<td>服务类型：</td>
						<td><?php echo $departName;?></td>
						<td>服务区域：</td>
						<td><?php echo $blockName;?></td>
						<td>操作</td>
						<td><?php 
						$stateHtml = "";
						if($state == PRO_ASK && $messagefkLev == LEV_ADMIN){
							$stateHtml = "<button class='btn btn-info' onclick=\"clickPassCheck($problemId)\">审核通过</button>
								<button class='btn btn-danger' onclick=\"clickNotPassCheck($problemId)\">审核不通过</button>";
						}else if($state == PRO_PASS && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
							$stateHtml = "<button class='btn btn-info' onclick=\"clickAccept($problemId)\">开始受理</button>";
						}						
						echo $stateHtml;
						?>
						</td>
					</tr>
					<tr>
						<td>申报标题：</td><td colspan="5"><?php echo $title;?></td>
					</tr>
					<tr>
						<td>申报内容</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							<pre><?php echo $content;?></pre>
						</td>
					</tr>
					<tr>
						<td colspan="6" class="problem-table-head">*付费信息</td>
					</tr>
					<tr>
						<td class="<?php echo $fixClass;?>">收费描述</td>
						<td colspan="3" style="height: 80px;">
							<?php 
								if($state == PRO_ACCEPT && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
									echo "<textarea id=\"chargeContent\" class=\"chargeContent\">无</textarea>";
								}else{
									echo "$chargeContent";
								}
							?>							
						</td>
						<td class="<?php echo $fixClass;?>">金额：</td>							
						<td>
							<?php 
								if($state == PRO_ACCEPT && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
									echo "<input id=\"totalCharge\" type=\"text\" style=\"width:100px\" value=\"0\">元";
								}else{
									echo "$totalCharge";
								}
							?>	
						</td>
					</tr>
					<tr>
						<td colspan="6" class="problem-table-head">*受理信息</td>
					</tr>
					<tr>
						<td>受理人邮箱：</td><td><?php echo $fixEmail;?></td>
						<td>受理时间：</td><td><?php echo $acceptTime;?></td>
						<td class="<?php echo $fixClass;?>">维修人：</td>
						<td>
							<?php 
								if($state == PRO_ACCEPT && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
									echo "<input id=\"fixProple\" type=\"text\" style=\"width:100px\" >";
								}else{
									echo "$fixProple ";
								}
							?>	
						</td>
					</tr>
					<tr>
						<td>完成时间：</td> <td><?php echo $finishTime;?></td>
						<td>用时(分)</td> <td><?php echo $totalTime;?></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="<?php echo $fixClass;?>">维修效果：</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							<?php 
								if($state == PRO_ACCEPT && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
									echo "<textarea id=\"fixResult\" class=\"chargeContent\">修好</textarea>";
								}else{
									echo "$result";
								}
							?>	
						</td>
					</tr>
					<tr>
						<td colspan="6" class="problem-table-head">*服务评价</td>
					</tr>
					<tr>
						<td>服务打分:</td>
						<td>
							<?php if(($state == PRO_FINISH  && $messagefkId == $userId)|| $state == PRO_OVER){?>
							<div style="float: left;">
								<div id="grade-box" class="grade-box">
									<ul>
										<li id="1" title="非常不滿意"></li>
										<li id="2" title="不滿意"></li>
										<li id="3" title="一般"></li>
										<li id="4" title="滿意"></li>
										<li id="5" title="非常滿意"></li>
									</ul>
									<div id="start-grade" class="start-grade"></div>
									<script type="text/javascript">
										<?php if($state == PRO_OVER){?>
											$(document).ready(function () {
												$("#start-grade").width(<?php echo $star;?> * 26);
											});
										<?php }else{?>
											$(document).ready(function () {
												$("#start-grade").width(5 * 26);
											});	
											$("#grade-box li").mouseover(function() {
												$("#start-grade").width($(this).attr("id") * 26);
											});
										<?php }?>
			                        </script>
								</div>
							</div> <?php }?>
						</td>
						<td>回访时间:</td><td><?php echo $overTime;?></td>
						<td></td>
						<td></td>
					</tr>


					<tr>
						<td>服务评价</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							<?php 
								if($state == PRO_FINISH  && $messagefkId == $userId){
									echo "<textarea id=\"starContent\" class=\"chargeContent\"></textarea>";
								}else{
									echo "$starContent";
								}
							?>	
						</td>
					</tr>
					<?php 
					if($state == PRO_ACCEPT && $messagefkLev == LEV_FIX && $messagefkId == $departMangerId){
						echo "<tr><td colspan='5' style='text-align: center;'><button class='btn btn-info' onclick=\"clickFinish($problemId)\">提交</button></td></tr>";						
					}else if($state == PRO_FINISH  && $messagefkId == $userId){
						echo "<tr><td colspan='5' style='text-align: center;'><button class='btn btn-info' onclick=\"clickOver($problemId)\">評價</button></td></tr>";						
					}
					?>
				</tbody>
			</table>


		</div>
	</div>
</div>
<script
	src="js/problem.js<?php echo "?t=".time ();?>"></script>
<script>
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
});
</script>
<?php include_once('inc/footer.inc.php'); ?>
<?php include_once('inc/end.php'); ?>