<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/1
 * Time: 14:03
 */
require_once("../connect/conn.php");
session_start();
$wtid = $_SESSION['wtid'];
$cid = $_SESSION['cid'];
$sid = $_SESSION['id'];
$title = $_GET['title']
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li onclick="gotoPage('student/sWork.php?cid='+ <?php echo $cid ?>)" class="link">作业</li>
        <li class="active"><?php echo $title ?></li>
    </ol>
</div>
