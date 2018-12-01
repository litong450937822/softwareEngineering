<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/25
 * Time: 10:52
 */
require_once("../connect/conn.php");
session_start();
$wtid = $_GET['wtid'];
$_SESSION['wtid'] = $wtid;
$cid = $_SESSION['cid'];
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "select * from work_t where wtid = $wtid");
$row = mysqli_fetch_assoc($rs);
$rs1 = mysqli_query($conn, "select * from work_s where wtid = $wtid AND sid = $sid");
$nowTime = date('Y/m/d h:i');
$endTime = $row['endTime'];
?>
<style>
    .content {
        border: #eee 1px solid;
        padding: 20px 20px 20px;
    }
</style>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li onclick="gotoPage('student/sWork.php?cid='+ <?php echo $cid ?>)" class="link">作业</li>
        <li class="active"><?php echo $row['title'] ?></li>
    </ol>
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
        <fieldset style="margin-top: 30px;">
            <legend>作业描述</legend>
            <p><?php echo $row['content'] ?></p>
        </fieldset>
        <fieldset style="margin-top: 30px;">
            <legend>我的答案</legend>
            <?php if (mysqli_num_rows($rs1) >= 1) {
                $row1 = mysqli_fetch_assoc($rs1) ?>
                <table class="layui-table" lay-skin="nob" style="margin: auto">
                    <colgroup>
                        <col width="1000">
                        <col width="200">
                    </colgroup>
                    <tr class="link" data-method="offset" data-cont="<?php echo $row1['content'] ?>"
                        data-file="<?php echo $row1['file'] ?>" id="work">
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
            } ?>" onclick="gotoPage('student/submitWork.php?title= <?php echo $row['title'] ?>')">
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
                    file = othis.data('file');
                let files = file.split(';');

                layer.open({
                    type: 1
                    , title: false
                    , area: ['500px', '400px']
                    , offset: 'auto' //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
                    , id: 'submitWork' //防止重复弹出
                    , content: '<div style="margin: 20px">' +
                    '<fieldset style="margin-top: 30px;">\n' +
                    '            <legend>我的答案</legend>' +
                    '</fieldset>' +
                    content +
                    '<fieldset style="margin-top: 30px;">\n' +
                    '            <legend>附件</legend>' +
                    '</fieldset>' +
                    <?php
                    if (mysqli_num_rows($rs1) >= 1){
                    $files = explode(';', $row1['file']);
                    foreach($files as $file){
                    ?>
                    '<a href="./file/<?php echo $file ?>" download="filename"><?php echo $file ?></a><br/>' +
                    <?php }}  ?>
                    '</div>'
                    , btn: ['保存', '关闭']
                    , btnAlign: 'c' //按钮居中
                    , shade: 0.3
                    , closeBtn: 0
                    , btn1: function () {
                    }
                    , function () {
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

    layui.use('upload', function () {
        let $ = layui.jquery
            , upload = layui.upload;
        let demoListView = $('#demoList')
            , uploadListIns = upload.render({
            elem: '#testList'
            , url: '/upload/'
            , accept: 'file'
            , multiple: true
            , auto: false
            , bindAction: '#testListAction'
            , choose: function (obj) {
                let files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function (index, file, result) {
                    let tr = $(['<tr id="upload-' + index + '">'
                        , '<td>' + file.name + '</td>'
                        , '<td>' + (file.size / 1014).toFixed(1) + 'kb</td>'
                        , '<td>等待上传</td>'
                        , '<td>'
                        , '<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                        , '<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        , '</td>'
                        , '</tr>'].join(''));

                    //单个重传
                    tr.find('.demo-reload').on('click', function () {
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function () {
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView.append(tr);
                });
            }
            , done: function (res, index, upload) {
                if (res.code === 0) { //上传成功
                    let tr = demoListView.find('tr#upload-' + index)
                        , tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            , error: function (index, upload) {
                let tr = demoListView.find('tr#upload-' + index)
                    , tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    });

    $('#testList').on('click', function () {
        alert(111)
    })
</script>