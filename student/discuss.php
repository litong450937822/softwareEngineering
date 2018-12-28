<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/27
 * Time: 0:31
 */

require_once("../connect/conn.php");
session_start();
$dtid = $_GET['dtid'];
$rs = mysqli_query($conn, "select * from discass_s left join student on discass_s.sid = student.sid
 where dtid = $dtid");
$rs1 = mysqli_query($conn, "select * from discass_t where dtid = $dtid");
$row1 = mysqli_fetch_assoc($rs1);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li class="active">讨论</li>
    </ol>
    <p><?php echo $row1['title']  ?></p>

</div>
