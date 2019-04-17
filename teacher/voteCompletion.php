<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/27
 * Time: 22:32
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$vtid = $_GET['vtid'];
$clid = $_SESSION['clid'];
$sql = "SELECT * FROM vote_t WHERE vtid = $vtid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$options = explode(";", $row['options']);
$len = count($options);
$sql1 = "SELECT student.name,vote_s.vtid, student.sid,result FROM student LEFT JOIN vote_s ON student.sid = vote_s.sid AND vtid = $vtid WHERE clid = $clid ";
$rs1 = mysqli_query($conn, $sql1);
$countPerson = mysqli_num_rows($rs1);
$finish = 0;
$result = '';

function statistical($number)
{
    global $conn, $vtid, $finish, $result;
    $rs = mysqli_query($conn, "SELECT * FROM vote_s WHERE result = $number AND vtid = $vtid");
    $count = mysqli_num_rows($rs);
    if ($count != 0)
        $result = @round(($count / $finish) * 100) . "%";
    else
        $result = '0%';
}


?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseTest.php.php')">测试</a>
            <a><cite><?php echo $row['title'] ?></cite></a>
        </span>
    </div>
    <div class="content">

        <table style="background-color: #eee;">
            <colgroup>
                <col width="150">
                <col width="500">
                <col width="150">
                <col width="500">
            </colgroup>
            <tr style="height: 40px;">
                <td style="padding: 20px">测试标题：</td>
                <td><?php echo $row['title'] ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="height: 40px;">
                <td style="padding: 20px">开放时间：</td>
                <td><?php echo $row['startTime'] ?></td>
                <td>交付截止时间：</td>
                <td><?php echo $row['endTime'] ?></td>
            </tr>
        </table>

        <table class="layui-table" lay-skin="line" style="margin: 20px auto auto;">
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
                <tr>
                    <td><?php echo $row1['name'] ?></td>
                    <td style="text-align: center">
                        <?php if ($row1['result'] == null)
                            echo '<p style="color: #FF5722">未提交</p>';
                        else {
                            echo '<p>已完成</p>';
                            $finish++;
                        }
                        ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>完成情况</legend>
        </fieldset>
        <table style="background-color: #eee;">
            <colgroup>
                <col width="600">
                <col width="150">
                <col width="1000">
            </colgroup>
            <tr style="height: 40px;">
                <td style="padding: 20px">完成人员：<?php echo round(($finish / $countPerson) * 100) . '%' ?></td>
                <td></td>
            </tr>
            <?php
            for ($i = 0; $i < $len; $i++) {
                statistical($i);
                ?>
                <tr>
                    <td style="padding:20px">选项<?php echo $i + 1; ?>：<?php echo $options[$i]; ?></td>
                    <td colspan="2">结果：<?php echo $result ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

</div>

<script>

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

</script>