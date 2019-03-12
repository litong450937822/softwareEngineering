<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/3
 * Time: 10:24
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$vtid = $_GET['vtid'];
$_SESSION['vtid'] = $vtid;
$clid = $_SESSION['clid'];
$sql = "SELECT * FROM vote_t WHERE vtid = $vtid";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$nowTime = date('Y/m/d H:i:s');
$endTime = $row['endTime'];
$date = date('Y/m/d');
$sql = "INSERT INTO time (date, type, sid) VALUES ('" . $date . "','V',$sid)";
$conn->query($sql);
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a class="link" onclick="gotoPage('student/courseVote.php')">课程问卷</a>
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
                <td style="padding: 20px">投票名称：</td>
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
        <form class="layui-form layui-form-pane" action="" lay-filter="vote">
            <div style='border: #eee 1px solid;padding: 20px;margin-top: 20px;height: auto'>

                <div class="layui-form-item">
                    <label class="layui-form-label">选项</label>
                    <div class="layui-input-block">
                        <select name="result" lay-verify="required">
                            <option value=""></option>
                            <?php
                            $option = explode(";", $row['options']);
                            for ($i = 0;$i < count($option);$i++){
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $option[$i];  ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div align="center">

                    <button class="layui-btn <?php if (strtotime($nowTime) - strtotime($endTime) > 0)
                    echo 'layui-btn-disabled'; ?>" lay-submit=""
                            lay-filter="insertVote"

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
            let form = layui.form;

            form.render();
            //日期
            form.on('submit(insertVote)', function (data) {
                <?php if (strtotime($nowTime) - strtotime($endTime) <= 0) { ?>
                $.ajax({
                    url: './php/insertVote_s.php',
                    type: 'post',
                    data: data.field,
                    success: function (data) {
                        gotoPage('student/courseVote.php');
                    },
                    error: function () {
                        layer.msg("该投票您已参加过");
                    }
                });
                <?php
                }
                ?>
                return false; //阻止表单跳转
            });
        });
    </script>