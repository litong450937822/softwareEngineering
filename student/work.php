<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/25
 * Time: 10:52
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$wtid = $_GET['wtid'];
$_SESSION['wtid'] = $wtid;
$schoolNumber = $_SESSION['number'];
echo $_SESSION['number'];
$cid = $_SESSION['cid'];
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "select * from work_t where wtid = $wtid");
$row = mysqli_fetch_assoc($rs);
$rs1 = mysqli_query($conn, "select * from work_s where wtid = $wtid AND sid = $sid");
$nowTime = date('Y/m/d h:i');
$endTime = $row['endTime'];
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a class="link" onclick="gotoPage('student/sWork.php?cid='+ <?php echo $cid ?>)">作业</a>
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
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>我的答案</legend>
            <?php if (mysqli_num_rows($rs1) >= 1) {
                $row1 = mysqli_fetch_assoc($rs1) ?>
                <table class="layui-table" lay-skin="nob" style="margin: auto">
                    <colgroup>
                        <col width="1000">
                        <col width="200">
                    </colgroup>
                    <tr class="link" data-method="offset" data-cont="<?php echo $row1['answer'] ?>"
                        data-title="<?php echo $row['title'] ?>" id="work">
                        <td>我的答案</td>
                        <td><?php echo $row1['submitTime'] ?></td>
                    </tr>
                </table>
            <?php } else { ?>
                <p>暂未提交答案</p>
            <?php } ?>
            <button class="layui-btn <?php
            if (strtotime($nowTime) - strtotime($endTime) > 0) {
                echo 'layui-btn-disabled';
            } ?>" onclick="<?php if (strtotime($nowTime) - strtotime($endTime) <= 0) {
                ?>gotoPage('student/submitWork.php?title=+<?php echo $row['title'] ?>');
            <?php } ?>">
                <i class="layui-icon">&#xe62f;</i> 提交作业
            </button>
        </fieldset>
    </div>
</div>

<script>

    layui.use('layer', function () {
        let $ = layui.jquery, layer = layui.layer;
        let active = {
            offset: function (othis) {
                let content = othis.data('cont'),
                    title = othis.data('title');

                layer.open({
                    type: 1
                    , title: title
                    , area: ['500px', '400px']
                    , offset: 'auto' //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
                    , id: 'submitWork' //防止重复弹出
                    , content: '<div style="margin: 20px">' +
                        '<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">\n' +
                        '            <legend>我的答案</legend>' +
                        '</fieldset>' +
                        content +
                        '<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">\n' +
                        '            <legend>附件</legend>' +
                        '</fieldset>\n' +
                        <?php
                        if (mysqli_num_rows($rs1) >= 1){
                        if ($row1['file'] != null){
                        $files = explode(';', $row1['file']);
                        foreach($files as $file){
                        $suffix = explode('.', $file);
                        $suffix = end($suffix);
                        $suffix = strtolower($suffix);
                        $common = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
                        $video = ['avi', 'mp4', 'rmvb', 'wmv', 'mkv'];
                        $picture = ['bmp', 'jpg', 'jpge', 'png', 'gif', 'pcx', 'svg'];
                        $rar = ['rar', 'zip', '7z'];
                        ?>
                        '<img src="icon/<?php
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
                            ?>.png"width="18px" height="20px"/>' +
                        '<a href="./file/<?php echo $schoolNumber ?>/<?php echo $file ?>" download="<?php echo $file ?>"><?php echo $file ?></a><br/>' +
                        <?php }}}  ?>
                        '</div>'
                    , btnAlign: 'c' //按钮居中
                    , shade: 0.3
                    , shadeClose: true
                    , closeBtn: 1
                    , btn1: function () {
                    }
                    , function() {
                        layer.closeAll();
                    }
                });
            }
        };
        $('#work').on('click', function () {
            let othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        })
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>