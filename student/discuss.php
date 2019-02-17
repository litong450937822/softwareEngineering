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
$row = mysqli_fetch_assoc($rs);
$row1 = mysqli_fetch_assoc($rs1);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li class="link" onclick="gotoPage('student/courseDiscuss.php')">讨论</li>
        <li class="active"><?php echo $row1['title'] ?></li>
    </ol>
    <div style="background-color: #f5f5f5;border-radius: 3px;padding: 5px">
        <div style="background-color: #fff;border: 1px solid #eee;padding: 5px">
            <p style="font-size: 22px">讨论题目：<?php echo $row1['title'] ?></p>
            <p style="margin-top: 10px;">开始时间：<?php echo $row1['startTime'] ?></p>
            <p style="margin-top: 10px">最近一次回复时间：<?php echo $row1['lastUpdateTime'] ?></p>
        </div>
        <div style="background-color: #fff;border: 1px solid #eee;padding: 5px;margin-top: 5px">
            <table>
                <tr>
                    <td style="text-align: center">
                        <img src="img/default.jpg" class="layui-nav-img">
                        <p style="font-size: 22px"><?php echo $row['name'] ?></p>
                        <p style="margin-top: 10px"><?php echo $row['time'] ?></p>
                    </td>
                    <td><p style="margin-top: 10px;"><?php echo $row['result'] ?></p></td>
                </tr>




            </table>
        </div>

        <fieldset style="margin-top: 30px;">
            <legend>回复</legend>
            <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" class="layui-textarea" name="reply"></textarea>
                </div>
            </div>
    </div>

</div>

<script>

</script>