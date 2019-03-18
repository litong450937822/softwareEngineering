<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/3
 * Time: 10:24
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$qtid = $_GET['qtid'];
$_SESSION['qtid'] = $qtid;
$clid = $_SESSION['clid'];
$cid = $_SESSION['cid'];
$id = $_SESSION['id'];
$sql = "SELECT * FROM question_t WHERE qtid = $qtid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$sql1 = "SELECT * FROM question_q WHERE qtid = $qtid ";
$rs1 = mysqli_query($conn, $sql1);
$count = mysqli_num_rows($rs1);
$nowTime = date('Y/m/d H:i:s');
$endTime = $row['endTime'];
$date = date('Y/m/d');
$sql = "INSERT INTO time (date, type, sid, cid) VALUES ('" . $date . "','Q',$id,$cid)";
$conn->query($sql);
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a class="link" onclick="gotoPage('student/courseQuestionnaire.php')">问卷</a>
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
                <td>问题数量：</td>
                <td><?php echo $count ?></td>
            </tr>
            <tr style="height: 40px;">
                <td style="padding: 20px">开放时间：</td>
                <td><?php echo $row['startTime'] ?></td>
                <td>交付截止时间：</td>
                <td><?php echo $row['endTime'] ?></td>
            </tr>
        </table>
        <form class="layui-form layui-form-pane" action="" lay-filter="questionnaire">
            <div style='border: #eee 1px solid;padding: 20px;margin-top: 20px;height: auto'>
                <?php
                $number = 0;
                while ($row1 = mysqli_fetch_assoc($rs1)) {
                    $number++;
                    ?>
                    <div class="layui-form-item">
                        <p style="font-size: 24px"><?php echo $number . '.' . $row1['question'] ?></p>
                        <label class="layui-form-label">回答</label>
                        <div class="layui-input-block">
                            <select name="answer<?php echo $row1['number'] ?>" lay-verify="required">
                                <option value=""></option>
                                <option value="1">非常符合></option>
                                <option value="2">基本符合</option>
                                <option value="3">一般</option>
                                <option value="4">偏离</option>
                                <option value="5">严重偏离</option>
                            </select>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div align="center">

                    <button class="layui-btn <?php if (strtotime($nowTime) - strtotime($endTime) > 0)
                        echo 'layui-btn-disabled'; ?>" lay-submit=""
                            lay-filter="insertQuestionnaire"

                            id="submit" style="margin-top: 20px">提交
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>

        layui.use('element', function () {
            let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

            element.render();
        });

        layui.use(['form', 'layedit', 'laydate'], function () {
            let form = layui.form
                , layer = layui.layer
                , laydate = layui.laydate;

            form.render();
            //日期
            let answerStr = '';
            form.on('radio', function (data) {
                answerStr = answerStr + data + ';'
            });

            laydate.render({
                elem: '#startTime'
                , type: 'datetime'
                , format: 'yyyy/MM/dd HH:mm:ss'
            });

            laydate.render({
                elem: '#endTime'
                , type: 'datetime'
                , format: 'yyyy/MM/dd HH:mm:ss'
            });

            //自定义验证规则
            form.verify({
                title: function (value) {
                    if (value.length < 5) {
                        return '标题不得少于5个字符';
                    }
                }
                , endTime: function (value) {
                    if (value === '') {
                        return '必填项不能为空';
                    }
                    let startTime = $('#startTime').val();
                    let endTime = $('#endTime').val();
                    let start = new Date(startTime.replace("-", "/").replace("-", "/"));
                    let end = new Date(endTime.replace("-", "/").replace("-", "/"));
                    if (end < start) {
                        return '结束时间不能小于开始时间';
                    }
                }
            });

            form.on('submit(insertQuestionnaire)', function (data) {
                <?php if (strtotime($nowTime) - strtotime($endTime) <= 0) { ?>
                $.ajax({
                    url: './php/insertQuestionnaire_s.php',
                    type: 'post',
                    data: data.field,
                    success: function (data) {
                        gotoPage('student/courseQuestionnaire.php');
                    }
                });
                <?php
                }
                ?>
                return false; //阻止表单跳转
            });
        });
    </script>