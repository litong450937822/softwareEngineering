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
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li class="active">投票</li>
    </ol>


</div>
