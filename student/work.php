<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/25
 * Time: 10:52
 */
require_once("../connect/conn.php");
session_start();
$wtid = $_GET['wtid'];
$cid = $_SESSION['cid'];
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "select * from work_t where wtid = $wtid");
$row = mysqli_fetch_assoc($rs);
$rs1 = mysqli_query($conn, "select * from work_s where wtid = $wtid AND sid = $sid");
$nowTime = date('Y/m/d h:i');
$endTime = $row['endTime'];
echo $nowTime;
echo $endTime;
if (strtotime($nowTime) - strtotime($endTime) < 0) {                   //对两个时间差进行差运算

//    echo "nowTime早于endTime";                              //time1-time2<0，说明time1的时间在前

} else {

//    echo "endTime早于nowTime";                              //否则，说明time2的时间在前

}
?>
<style>
    .content {
        border: #eee 1px solid;
        padding: 20px 20px 20px;
    }
</style>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li onclick="gotoPage('student/sWork.php?cid='+ <?php echo $cid ?>)" class="link">作业</li>
        <li class="active"><?php echo $row['title'] ?></li>
    </ol>
    <div class="content">
        <p style="font-size: 24px"><?php echo $row['title'] ?></p>
        <table style="background-color: #eee;">
            <colgroup>
                <col width="150">
                <col width="500">
                <col width="150">
                <col width="500">
            </colgroup>
            <tr style="height: 40px;">
                <td style="padding: 20px">开放时间：</td>
                <td><?php echo $row['startTime'] ?></td>
                <td>交付截止时间：</td>
                <td><?php echo $row['endTime'] ?></td>
            </tr>
            <tr style="height: 40px">
                <td style="padding: 20px">作业形式：</td>
                <td>个人作业</td>
                <td>完成指标：</td>
                <td>提交作业</td>
            </tr>
        </table>
        <fieldset style="margin-top: 30px;">
            <legend>作业描述</legend>
            <p><?php echo $row['content'] ?></p>
        </fieldset>
        <fieldset style="margin-top: 30px;">
            <legend>我的答案</legend>
            <?php if (mysqli_num_rows($rs1) >= 1) {
                $row1 = mysqli_fetch_assoc($rs1) ?>
                <table class="layui-table" lay-skin="nob" style="margin: auto">
                    <colgroup>
                        <col width="1000">
                        <col width="200">
                    </colgroup>
                    <tr class="link">
                        <td>我的答案</td>
                        <td><?php echo $row1['submitTime'] ?></td>
                    </tr>
                </table>
            <?php } else { ?>
                <p>暂未提交答案</p>
                <button class="layui-btn"><i class="layui-icon">&#xe62f;</i>提交作业</button>
            <?php } ?>
        </fieldset>

    </div>
</div>


