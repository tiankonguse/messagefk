<?php
session_start();
$title = "已经实现的功能";
require_once('inc/header.inc.php');
$messagefkLev  = -1;
$messagefkEmail = "";
?>
<div class="wrap">
<?php require_once('inc/top.inc.php'); ?>
<?php require_once('inc/nav.inc.php'); ?>

<style type="text/css">
.list{
    padding-top: 10px;
    padding-bottom: 5px;
    border-bottom-width: 1px;
    border-bottom-color: rgba(63, 63, 63, 0.16);
    border-bottom-style: dotted;
    padding-left: 20px;
    text-align: center;
}
.list:hover {
    background-color: #E0E0E0;
}
.red{
    color:red;
}
.head{
    text-align: center;
    margin-bottom: 30px;
}
.body{
    margin-bottom: 30px;
}
.footer{
    text-align: center;
}
</style>

    <div class="content">
       <div class="head">
            <h1>已经实现的功能</h1>
       </div>
       <div class="body">
            <div class="list">
                * 首页显示各个级别的问题（有分页功能）
           </div>
           
           <div class="list">
                * 登录 （之后需要改成使用师大邮箱帐号登录）
           </div>

           <div class="list">
                * 提交问题
           </div>
           
           <div class="list">
                * 管理员审核问题
           </div>
           
           <div class="list">
                * 中心 受理问题及维修后填写相关信息
           </div>
           
           <div class="list">
                * 用户评价问题
           </div>
           
           <div class="list">
                * 用户查看自己提交的问题
           </div>
           
           <div class="list">
                * 管理各大分类，及指定管理员。
           </div>
        
           <div class="list">
                * 管理员为管理大分类中的小分类
           </div>
        
           <div class="list">
                * 发短信功能 （这个需要再次协商，确认那些需要发短信，给谁发短信）
                * 发短信间隔至少15秒，需要做成后台处理
           </div>
           
           <div class="list">
                * 统计（后面几个意思没有看懂,协商之后制作）
           </div>
           
           <div class="list">
                * 二十四小时提醒（需要协商后制作，不同条件下制作方式不同）
           </div>
            
       </div>
       <div class="red footer">
            注：目前只是开发阶段，需要测试。
       </div>
 
        
    </div>
</div>
<script>


