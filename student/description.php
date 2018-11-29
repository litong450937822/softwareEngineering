<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/26
 * Time: 22:00
 */
require_once("../connect/conn.php");
session_start();
$cid = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$_SESSION['cid'] = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$sid = @$_SESSION['id'];
$rs = mysqli_query($conn, "select * from course left join teacher on course.tid = teacher.tid 
 left join class on course.clid = class.clid
where cid = $cid");
$row = mysqli_fetch_assoc($rs);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li class="active">课程介绍</li>
    </ol>
    <table>
        <tr>
            <td>
                <img src="./img/course-cover-default.png" style="width: 590px; height: 320px">
            </td>
            <td style="padding-left: 30px">
                <p style="font-size: 24px; font-weight: bold;line-height: 60px "><?php echo $row['courseName'] ?></p>
                <p>班级：<?php echo $row['className'] ?></p>
                <p><?php echo $row['semester'] ?></p>

            </td>
        </tr>
    </table>
</div>
