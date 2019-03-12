<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/28
 * Time: 20:33
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$wtid = $_GET['wtid'];
$sid = $_GET['sid'];

$rs = mysqli_query($conn, "SELECT name FROM student WHERE sid = $sid");
$row = mysqli_fetch_assoc($rs);
$name = $row['name'];
$rs = mysqli_query($conn, "SELECT title FROM work_t WHERE wtid = $wtid");
$row = mysqli_fetch_assoc($rs);
$title = $row['title'];
$sql = "SELECT work_s.file,work_s.answer,score,submitTime,number FROM work_s 
  LEFT JOIN work_t ON work_t.wtid=work_s.wtid 
  LEFT JOIN student on work_s.sid = student.sid WHERE work_s.wtid=$wtid AND work_s.sid = $sid";
$rs = mysqli_query($conn, $sql);

?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/sWork.php')">作业</a>
            <a class="link"
               onclick="gotoPage('teacher/workCompletion.php?wtid=<?php echo $wtid; ?>')"><?php echo $title; ?></a>
            <a><cite><?php echo $name; ?></cite></a>
        </span>
    </div>
    <div class="content">

        <?php
        if (mysqli_num_rows($rs) >= 1) {
            $row = mysqli_fetch_assoc($rs);
            ?>
            <table>
                <colgroup>
                    <col width="1000">
                    <col width="1000">
                </colgroup>
                <tr style="font-size: 18px">
                    <td style="padding-left: 20px;"><?php echo $name; ?></td>
                    <td>提交日期：<?php echo $row['submitTime']; ?></td>
                </tr>
            </table>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend style="margin-bottom: 5px">作业答案</legend>
                <p><?php echo $row['answer'] ?></p>
            </fieldset>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend style="margin-bottom: 5px">附件</legend>
            <?php
            if ($row['file'] != null) {
                $files = explode(';', $row['file']);
                foreach ($files as $file) {
                    $suffix = explode('.', $file);
                    $suffix = end($suffix);
                    $suffix = strtolower($suffix);
                    $common = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
                    $video = ['avi', 'mp4', 'rmvb', 'wmv', 'mkv'];
                    $picture = ['bmp', 'jpg', 'jpge', 'png', 'gif', 'pcx', 'svg'];
                    $rar = ['rar', 'zip', '7z'];
                    ?>
                    <img src="icon/<?php
                    if (in_array($suffix, $common))
                        echo $suffix;
                    elseif (in_array($suffix, $video))
                        echo 'video';
                    elseif (in_array($suffix, $picture))
                        echo 'picture';
                    elseif (in_array($suffix, $rar))
                        echo 'rar';
                    else
                        echo 'file';
                    ?>.png" width="18px" height="20px"/>
                    <a href="./file/<?php echo $row['number'] ?>/<?php echo $file ?>"
                       download="<?php echo $file ?>"><?php echo $file ?></a>
                    <br/>
                    <?php
                }
            } ?>
            </fieldset>
            <form class="layui-form" action="" lay-filter="score" style="margin-top: 20px">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 30px">得分</label>
                    <div class="layui-input-inline">
                        <input type="text" id="score"
                               name="socre" autocomplete="off" placeholder="请输入得分" lay-verify="socre"
                               class="layui-input">
                    </div>
                </div>
                <button class="layui-btn layui-col-md-offset5" lay-submit="" lay-filter="updateScore" id="submit">提交
                </button>
            </form>
            <?php
        } else {
            ?>
            <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
                <p style="color: #999;font-size: 30px;font-weight: bolder">该学生尚未提交作业</p>
            </div>

            <?php
        }
        ?>
    </div>
</div>

<script>
    layui.use(['element', 'form'], function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块
        let form = layui.form;

        form.verify({
            socre: [/^(?:0|[1-9][0-9]?|100)$/, '得分必须为0-100的数字']
        });

        form.on('submit(updateScore)', function (data) {
            $.ajax({
                url: './php/updateScore.php',
                type: 'post',
                data: {
                    score: $('#score').val()
                    , wtid:<?php echo $wtid; ?>
                    , sid:<?php echo $sid; ?>
                }
            });
            gotoPage('teacher/workCompletion.php?wtid=<?php echo $wtid; ?>');
            return false; //阻止表单跳转
        });
        element.render();
    });


</script>