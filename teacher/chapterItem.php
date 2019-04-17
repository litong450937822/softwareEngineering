<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/19
 * Time: 22:53
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$chid = $_GET['chid'];
$rs = mysqli_query($conn,"SELECT number From course LEFT JOIN teacher t ON course.tid = t.tid WHERE cid = $cid");
$row = mysqli_fetch_assoc($rs);
$number = $row['number'];
$rs = mysqli_query($conn, "SELECT * FROM chapter WHERE chid = $chid");
$row = mysqli_fetch_assoc($rs);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseChapter.php')">课程章节</a>
            <a><cite><?php echo $row['title'] ?></cite></a>
        </span>
    </div>
    <table style="background-color: #eee;">
        <colgroup>
            <col width="150">
            <col width="500">
            <col width="150">
            <col width="500">
        </colgroup>
        <tr style="height: 40px;">
            <td style="padding: 20px">开放时间：</td>
            <td><?php echo $row['time'] ?></td>
            <td>完成指标：</td>
            <td><?php
            if ($row['type'] == 'A')
                echo '观看或下载所有参考文件附件';
            elseif ($row['type'] == 'K')
                echo '访问线上链接' ?></td>
        </tr>
    </table>
    <?php
    if ($row['type'] == 'A') {
        ?>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>附件</legend>
            <?php
            $files = explode(';', $row['content']);
            foreach($files as $file){
                $suffix = explode('.', $file);
                $suffix = end($suffix);
                $suffix = strtolower($suffix);
                $common = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
                $video = ['avi', 'mp4', 'rmvb', 'wmv', 'mkv'];
                $picture = ['bmp', 'jpg', 'jpge', 'png', 'gif', 'pcx', 'svg'];
                $rar = ['rar', 'zip', '7z'];
                ?>
                <a href="./file/<?php echo $number ?>/<?php echo $file ?>" download="<?php echo $file ?>"
                   style="margin: 10px 10px;font-size: 20px">
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
                    ?>.png" width="18px" height="20px"/><?php echo $file ?></a><br/>
            <?php }  ?>
        </fieldset>
        <?php
    }else {
        ?>
        <a href="<?php echo $row['content'] ?>" target="_blank">新窗口打开</a>
        <?php
    }
    ?>
</div>
<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>