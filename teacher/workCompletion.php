<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/27
 * Time: 22:32
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$wtid = $_GET['wtid'];
$clid = $_SESSION['clid'];
$sql = "SELECT * FROM work_t WHERE wtid = $wtid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$sql1 = "SELECT student.name,work_s.score,work_s.wtid, student.sid FROM student LEFT JOIN work_s ON student.sid = work_s.sid AND wtid = $wtid WHERE clid = $clid ";
$rs1 = mysqli_query($conn, $sql1);
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/sWork.php')">作业</a>
            <a><cite><?php echo $row['title'] ?></cite></a>
        </span>
    </div>
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
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>作业描述</legend>
            <p><?php echo $row['content'] ?></p>
        </fieldset>

        <table class="layui-table" lay-skin="line" style="margin: auto">
            <colgroup>
                <col width="550px">
                <col width="70px">
            </colgroup>
            <thead>
            <tr>
                <th>姓名</th>
                <th style="text-align: center">得分</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row1 = mysqli_fetch_assoc($rs1)) {
                ?>
                <tr onclick="gotoPage('teacher/browseWork.php?wtid=<?php echo $wtid ?>&sid=<?php
                echo $row1['sid'] ?>')">
                    <td><?php echo $row1['name'] ?></td>
                    <td style="text-align: center">
                        <?php if ($row1['score'] == null)
                            echo '<p style="color: #FF5722">未提交</p>';
                        else
                            echo $row1['score']
                        ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<script>

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

</script>