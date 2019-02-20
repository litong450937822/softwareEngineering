<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/10
 * Time: 14:47
 */

require_once("../connect/conn.php");
session_start();
$cid = $_SESSION['cid'];
$rs = mysqli_query($conn, "select * from vote_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <ol class="breadcrumb">
        <li onclick="backToSelect('s')" class="link">课程选择</li>
        <li class="active">投票</li>
    </ol>
    <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
        <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无投票</p>
    </div>

</div>
