<?php
session_start();
require("inc/init.php");
$title = "信息反馈系统提交問題";
require('inc/header.inc.php');
require('inc/function.php');

$messagefkId    = $_SESSION['messagefkId'];
$messagefkEmail = $_SESSION['messagefkEmail'];
$messagefkLev   = $_SESSION['messagefkLev'];

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


$title = $row['title'];
$content = $row['content'];


$departId = $row['depart_id'];
$departName = getDepartName($departId);
$departMangerId = getDepartMangerId($departId);


$blockId = $row['block_id'];
$blockName = getBlocktName($blockId);

$phone = $row['phone'];

$state = $row['state'];

$suggestTime = "";
$passTime = "";


$suggestTime = getStateTime($problemId,1);

if($state != PRO_NOT_PASS && $state >= PRO_PASS){
	$passTime = getStateTime($problemId,2);
	$passTime = date("Y-m-d h:i:s",$passTime);
}


$formId = date("Ymdhis",$suggestTime) . $problemId;

$suggestTime = date("Y-m-d h:i:s",$suggestTime);

$stateHtml = getStateHtml($state);


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
					<div class="<?php if($state != PRO_NOT_PASS && $state >=2){echo "step-down";}?>">
						<div class="step-name">审核通过</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div class="<?php if($state != PRO_NOT_PASS && $state >=3){echo "step-down";}?>">
						<div class="step-name">受理通过</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div class="<?php if($state != PRO_NOT_PASS && $state >=3){echo "step-down";}?>">
						<div class="step-name">正在維修中</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li>
					<div class="<?php if($state != PRO_NOT_PASS && $state >=4){echo "step-down";}?>">
						<div class="step-name">維修完成</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li class="step-last">
					<div class="<?php if($state != PRO_NOT_PASS && $state >=5){echo "step-down";}?>">
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
						<td  colspan="6"  class="problem-table-head">申报信息</td>
					</tr>
					<tr>
						<td>单据号:</td><td><?php echo $formId;?></td>
						<td>状态：</td><td><?php echo $stateHtml;?></td>
						<td>申报时间：</td> <td><?php echo $suggestTime;?></td>
					</tr>
					<tr>
						<td>申报人：</td> <td><?php echo $userName;?></td>
						<td>申报电话：</td> <td><?php echo $phone;?></td>
						<td>审核时间：</td> <td><?php echo $passTime;?></td>
					</tr>
					<tr>
						<td>服务类型：</td> <td><?php echo $departName;?></td>
						<td>服务区域：</td> <td><?php echo $blockName;?></td>
						<td>操作</td> <td>

<?php 
	$stateHtml = "";
	if($state == PRO_ASK && $messagefkLev == LEV_ADMIN){
		$stateHtml = "						
			<button class='btn btn-info' onclick=\"clickPassCheck($problemId)\">审核通过</button>
			<button class='btn btn-danger' onclick=\"clickNotPassCheck($problemId)\">审核不通过</button>
		";
	}
	echo $stateHtml;
?>


						</td>
					</tr>
					<tr>
						<td>申报标题：</td> <td colspan="5"><?php echo $title;?></td>
					</tr>
					<tr>
						<td>申报内容</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							<pre><?php echo $content;?></pre>
						</td>
					</tr>
					
					<tr>
						<td colspan="6"  class="problem-table-head">*付费信息</td>
					</tr>
					<tr>
						<td >收费描述</td><td  colspan="3" style="height: 80px;" ></td>
						<td>金额：</td><td></td>
					</tr>
					
					<tr>
						<td colspan="6"  class="problem-table-head">*受理信息</td>
					</tr>
					<tr>
						<td>受理人邮箱：</td> <td></td>
						<td>受理时间：</td><td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>维修人：</td><td></td>
						<td>派出时间：</td><td></td>
						<td></td><td></td>
					</tr>

					<tr>
						<td>完成时间：</td><td></td>
						<td>用时(分)</td><td></td>
						<td></td><td></td>
					</tr>
					<tr>
						<td>维修效果：</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top"></td>
					</tr>
					
					<tr>
						<td colspan="6"  class="problem-table-head">*服务评价</td>
					</tr>
					<tr id="hf_cotent">
						<td>服务打分:</td>
						<td class="bxtitle1">
<?php if($state == PRO_FINISH){?>
							<div style="float: left;  id="hf_star">
								<div id="grade-box" class="grade-box">
									<ul>
										<li id="1" title="1星"></li>
										<li id="2" title="2星"></li>
										<li id="3" title="3星"></li>
										<li id="4" title="4星"></li>
										<li id="5" title="5星"></li>
									</ul>
									<div id="default-grade" class="default-grade"
										style="width: 0px;"></div>
									<div id="start-grade" class="start-grade"></div>
								</div>
								<script type="text/javascript">
                            var userGrade = false; //是否已经打过分
                            var avgGrade = '0'; //设置默认级别
                            if ("" == "待回访") {
                                avgGrade = '0'
                            }
                            else if ("" == "非常不满") {
                                avgGrade = '1'
                            }
                            else if ("" == "不满意") {
                                avgGrade = '2'
                            }
                            else if ("" == "一般满意") {
                                avgGrade = '3'
                            }
                            else if ("" == "满意") {
                                avgGrade = '4'
                            }
                            else if ("" == "非常满意") {
                                avgGrade = '5'
                            }
                            if (avgGrade.length > 0) {
                                $("#default-grade").width(avgGrade * 26);
                            }

                            $("#grade-box").hover(function () {
                                $("#default-grade").hide();
                            }, function () {
                                $("#default-grade").show();
                                $("#start-grade").width(0);
                            });
                            $("#grade-box li").mouseover(function () {
                                $("#start-grade").width($(this).attr("id") * 26);
                            });

                            //回访评价事件
                            $("#grade-box li").click(function () {
                                var userName = "李雪莲";
                                var loginName = "";
                                var Srp_count = "";
                                var grade = $(this).attr("id");
                                if (loginName.length == 0) {
                                    alert("您还没有登录，请先登录！谢谢"); return;
                                }
                                else if (userName == loginName) {
                                    alert("您对本次回访评价为：" + grade + "星,谢谢！");
                                }
                                else {
                                    alert("您不是回访人，不能评分！谢谢。"); return;
                                }
                                $("#default-grade").show();
                                $("#start-grade").width(0);
                                $("#default-grade").width(grade * 26);
                                // alert("您对本次回访评价为：" + grade + "星,谢谢！");
                                var score = grade * 20;
                                $.post("/C24H/tranScore", { score: score, wx_Serial: "f420e996-bd40-4f99-bc7e-a1f9011ccd93" }, function (data) {
                                    if (data == "ok") {
                                        window.location.reload();
                                    } else {
                                        alert(data);
                                        $("#hf_star").hide();
                                    }
                                })
                            });
                        </script>
							</div>
<?php }?>
						</td>
						<td>回访人:</td><td></td>
						<td>回访时间:</td><td></td>
					</tr>
					
					
					<tr>
						<td>服务评价</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							
						</td>
					</tr>

				</tbody>
			</table>


		</div>
	</div>
</div>
	<script src="js/problem.js<?php echo "?t=".time ();?>"></script>
	<script>
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
});
</script>
	<?php include_once('inc/footer.inc.php'); ?>
	<?php include_once('inc/end.php'); ?>