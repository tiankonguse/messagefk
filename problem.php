<?php
session_start();
require_once("inc/init.php");
$title = "信息反馈系统提交問題";
include_once('inc/header.inc.php');

$messagefk_id    = $_SESSION['messagefk_id'];
$messagefk_email = $_SESSION['messagefk_email'];
$messagefk_lev   = $_SESSION['messagefk_lev'];

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
					<div class="step-1 step-down">
						<div class="step-name">提交问题</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li>
					<div class="step-2 step-down">
						<div class="step-name">审核通过</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div class="step-3 step-down">
						<div class="step-name">通过受理</div>
						<div class="step-no"></div>
					</div>

				</li>
				<li>
					<div class="step-4 step-down">
						<div class="step-name">正在維修中</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li>
					<div class="step-5 step-down">
						<div class="step-name">維修完成</div>
						<div class="step-no"></div>
					</div>
				</li>
				<li class="step-last">
					<div class="step-6 step-down">
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
						<td class="problem-table-head">申报信息</td>
					</tr>
					<tr>
						<td>单据号:</td>
						<td>      </td>
						<td class="bxtitle">状态：</td>
						<td><span style="color: Red;">未审核</span>
						</td>
						<td class="bxtitle">申报人：</td>
						<td>李***</td>
					</tr>
					<tr>
						<td class="bxtitle">申报电话：</td>
						<td>1879*******</td>
						<td class="bxtitle">申报时间：</td>
						<td>2013-7-12 17:16:56</td>
						<td class="bxtitle">响应时间：</td>
						<td><span style="color: Red;"> 1002 </span>
						</td>
					</tr>
					<tr>
						<td class="bxtitle">服务类型：</td>
						<td>维修</td>
						<td class="bxtitle">服务项目：</td>
						<td>灯维修</td>
						<td class="bxtitle">服务区域：</td>
						<td>长安校区教学区</td>
					</tr>
					<tr>
						<td class="bxtitle">区域类型：</td>
						<td>有偿服务</td>
						<td class="bxtitle">报修地址：</td>
						<td colspan="3" style="width: 500px;">致****</td>
					</tr>
					<tr id="ycfw">
						<td class="bxtitle">申报部门：</td>
						<td>致知楼1304</td>
						<td class="bxtitle">预约时间：</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td class="bxtitle">申报内容：</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top">
							<p>老师您好，我们实验室的灯管坏了，请您派人给我们维修一下，谢谢老师！</p>
						</td>
					</tr>
					<tr>
						<td class="bxtitle">备注：</td>
						<td colspan="5" style="width: 500px;"></td>
					</tr>
					<tr>
						<td colspan="6" style="font-weight: bold; color: #2b7eca;"><em>*</em>付费信息</td>
					</tr>
					<tr>
						<td class="bxtitle">收费类型：</td>
						<td></td>
						<td class="bxtitle">金额：</td>
						<td colspan="3">0.00</td>
					</tr>
					<tr>
						<td colspan="6" style="font-weight: bold; color: #2b7eca;"><em>*</em>受理信息</td>
					</tr>
					<tr>
						<td class="bxtitle">受理人：</td>
						<td></td>
						<td class="bxtitle">受理时间：</td>
						<td></td>
						<td class="bxtitle">承修单位：</td>
						<td></td>
					</tr>
					<tr>
						<td class="bxtitle">承修人：</td>
						<td></td>
						<td class="bxtitle">派出人：</td>
						<td></td>
						<td class="bxtitle">派出时间：</td>
						<td></td>
					</tr>

					<tr>
						<td class="bxtitle">完成时间：</td>
						<td></td>
						<td class="bxtitle">用时(分)</td>
						<td>0</td>
						<td class="bxtitle">客户建议：</td>
						<td></td>
					</tr>
					<tr>
						<td class="bxtitle">维修效果：</td>
						<td colspan="5" style="width: 500px; height: 80px;" valign="top"></td>
					</tr>
					<tr id="hf_title">
						<td colspan="6" style="font-weight: bold; color: #2b7eca;"><em>*</em>服务回访</td>
					</tr>
					<tr id="hf_cotent">
						<td class="bxtitle">回访结果:</td>
						<td class="bxtitle1">
							<div style="float: left; display: none;" id="hf_star">
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
							<div style="float: left; line-height: 25px;">(待回访)</div>
						</td>
						<td class="bxtitle">回访人:</td>
						<td class="bxtitle1" id="hfr"></td>
						<td class="bxtitle">回访时间:</td>
						<td class="bxtitle1" id="hfsj"></td>
					</tr>
					<tr id="hf_bz" style="display: none;">
						<td style="font-weight: bold; text-align: right;">回访建议：</td>
						<td colspan="5" style="width: 500px; height: 80px;"><textarea
								id="wx_hfjy" style="width: 810px; height: 80px;"></textarea></td>
					</tr>
					<tr>
						<td colspan="6" style="font-weight: bold; color: #2b7eca;"><em>*</em>服务反馈</td>
					</tr>
					<tr>
						<td class="bxtitle" style="font-weight: bold; color: #2b7eca;"><em>*</em>评论内容：</td>
						<td colspan="5" style="width: 520px; height: 200px;"></td>
					</tr>
				</tbody>
			</table>


		</div>
	</div>
	<script src="js/suggest.js<?php echo "?t=".time ();?>"></script>
	<script>
$(document).ready(function(){
	$(".nav-top ul li.nav<?php echo $type; ?>").addClass("active");
});
</script>
	<?php include_once('inc/footer.inc.php'); ?>
	<?php include_once('inc/end.php'); ?>