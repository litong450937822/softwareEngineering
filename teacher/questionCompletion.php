<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/27
 * Time: 22:32
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$qtid = $_GET['qtid'];
$clid = $_SESSION['clid'];
$rs = mysqli_query($conn, "SELECT * FROM question_q WHERE qtid = $qtid");
$count = mysqli_num_rows($rs);
$sql = "SELECT * FROM question_t WHERE qtid = $qtid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$sql1 = "SELECT student.name,question_s.qtid, student.sid,result FROM student LEFT JOIN question_s ON student.sid = question_s.sid AND qtid = $qtid WHERE clid = $clid ";
$rs1 = mysqli_query($conn, $sql1);
$countPerson = mysqli_num_rows($rs1);
$finish = 0;
$result = '';

function statistical($number)
{
    global $conn, $qtid, $finish,$result;
    $answers = [];
    $option1 = 0;
    $option2 = 0;
    $option3 = 0;
    $option4 = 0;
    $option5 = 0;

//    $rs2 = mysqli_query($conn, "SELECT * FROM question_q WHERE qtid = $qtid AND number = $number");
//    $row2 = mysqli_fetch_assoc($rs2);
    $rs = mysqli_query($conn, "SELECT * FROM question_s LEFT JOIN student ON question_s.sid = student.sid  WHERE qtid = $qtid");
    while ($row = mysqli_fetch_assoc($rs)) {
        $answer = $row['result'];
        array_push($answers, $answer);
    }

    for ($i = 0; $i < count($answers); $i++) {
        $answerStr = $answers[$i];
        $answerArray = explode(';', $answerStr);
        switch ($answerArray[$number - 1]) {
            case 1:
                $option1++;
                break;
            case 2:
                $option2++;
                break;
            case 3:
                $option3++;
                break;
            case 4:
                $option4++;
                break;
            case 5:
                $option5++;
                break;
        }
    }
    if ($option1 == 0
        and $option2 == 0
        and $option3 == 0
        and $option4 == 0
        and $option5 == 0) {
        $probability1 = 0;
        $probability2 = 0;
        $probability3 = 0;
        $probability4 = 0;
        $probability5 = 0;
    }else{
        $probability1 = round(($option1 / $finish) * 100);
        $probability2 = round(($option2 / $finish) * 100);
        $probability3 = round(($option3 / $finish) * 100);
        $probability4 = round(($option4 / $finish) * 100);
        $probability5 = round(($option5 / $finish) * 100);
    }
    $result = "非常符合：" . $probability1 . "%  基本符合：" . $probability2 . "%  一般：" . $probability3 .
        "%  偏离：" . $probability4 . "%  严重偏离：" . $probability5 . "%";
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
                <col width="100">
                <col width="500">
                <col width="150">
                <col width="500">
            </colgroup>
            <tr style="height: 40px;">
                <td style="padding: 20px">测试标题：</td>
                <td><?php echo $row['title'] ?></td>
                <td>题目数量：</td>
                <td><?php echo $count ?></td>
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
                            echo '<p>已完成</p>' ;
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
            $rs2 = mysqli_query($conn, "SELECT * FROM question_q WHERE qtid = $qtid GROUP BY number");

            while ($row2 = mysqli_fetch_assoc($rs2)) {
                statistical($row2['number']);
                ?>
                <tr>
                    <td style="padding:20px">问题<?php echo $row2['number'] ?>：<?php echo $row2['question'] ?></td>
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