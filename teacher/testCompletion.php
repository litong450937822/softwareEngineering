<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/27
 * Time: 22:32
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$ttid = $_GET['ttid'];
$clid = $_SESSION['clid'];
$rs = mysqli_query($conn, "SELECT * FROM test_q WHERE ttid = $ttid");
$count = mysqli_num_rows($rs);
$sql = "SELECT * FROM test_t WHERE ttid = $ttid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$sql1 = "SELECT student.name,test_s.score,test_s.ttid, student.sid,answer FROM student LEFT JOIN test_s ON student.sid = test_s.sid AND ttid = $ttid WHERE clid = $clid ";
$rs1 = mysqli_query($conn, $sql1);
$countPerson = mysqli_num_rows($rs1);
$finish = 0;
$totalScore = 0;

$correct = 0;
$mistakePerson = '';

class answer
{
    public $answer;
    public $name;
}

function statistical($number)
{
    global $conn, $ttid, $mistakePerson, $correct;
    $answers = [];
    $correctNumber = 0;
    $mistakePerson = '';


    $rs = mysqli_query($conn, "SELECT * FROM test_s LEFT JOIN student ON test_s.sid = student.sid  WHERE ttid = $ttid");
    while ($row = mysqli_fetch_assoc($rs)) {
        $answer = new answer();
        $answer->str = $row['answer'];
        $answer->name = $row['name'];
        $answers[] = $answer;
    }
    $rs2 = mysqli_query($conn, "SELECT * FROM test_q WHERE ttid = $ttid AND number = $number");
    $questionCount = mysqli_num_rows($rs2);
    $row2 = mysqli_fetch_assoc($rs2);
    for ($i = 0; $i < count($answers); $i++) {
        $answerStr = $answers[$i]->str;
        $answerArray = explode(';', $answerStr);
        if ($answerArray[$number - 1] == $row2['answer'])
            $correctNumber++;
        else
            $mistakePerson = $mistakePerson . $answers[$i]->name;
    }
    if ($correctNumber != 0)
        $correct = round(($correctNumber / count($answers)) * 100);
    else
        $correct = 0;
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
                        <?php if ($row1['score'] == null)
                            echo '<p style="color: #FF5722">未提交</p>';
                        else {
                            echo $row1['score'];
                            $totalScore += $row1['score'];
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
                <td colspan="2">平均得分：<?php
                    if ($totalScore == 0)
                        echo '0';
                    else
                        echo round($totalScore / $finish) ?></td>
            </tr>
            <?php
            $rs2 = mysqli_query($conn, "SELECT * FROM test_q WHERE ttid = $ttid GROUP BY number");

            while ($row2 = mysqli_fetch_assoc($rs2)) {
                statistical($row2['number']);
                ?>
                <tr>
                    <td  style="padding:20px">第<?php echo $row2['number'] ?>题：<?php echo $row2['question'] ?></td>
                    <td>正确率：<?php echo $correct . '%' ?></td>
                    <td>错误名单：<?php echo $mistakePerson; ?></td>
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