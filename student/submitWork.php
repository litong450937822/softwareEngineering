<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/1
 * Time: 14:03
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$wtid = $_SESSION['wtid'];
$cid = $_SESSION['cid'];
$sid = $_SESSION['id'];
$title = $_GET['title'];
$_SESSION['workTime'] = date('H:i:s');

?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a class="link" onclick="gotoPage('student/sWork.php?cid='+ <?php echo $cid ?>)">作业</a>
            <a class="link" onclick="gotoPage('student/work.php?wtid='+<?php echo $wtid ?>)"><?php echo $title ?></a>
            <a><cite>作业提交</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">我的答案</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea" name="content" id="workContent"></textarea>
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>附件</legend>
        </fieldset>
        <div class="layui-upload">
            <div class="layui-upload-list">
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>文件名</th>
                        <th>大小</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="demoList"></tbody>
                </table>
            </div>
            <div class="layui-form-item">
                <button type="button" class="layui-btn" id="testList">选择文件</button>
                <button type="button" class="layui-btn" id="upload">上传文件</button>
            </div>
        </div>
        <button class="layui-btn " lay-submit="" lay-filter="insertWork" id="submit">提交</button>

    </form>
</div>
<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    layui.use('form', function () {
        let form = layui.form;


        form.render();

        form.on('submit(insertWork)', function (data) {
            let fileStr = '';
            $('td#fileName').each(function () {
                fileStr += $(this).text() + ';';
            });
            fileStr = fileStr.substr(0, fileStr.length - 1);
            data.field.file = fileStr;
            $.ajax({
                url: './php/submitWork.php',
                type: 'post',
                data: data.field,
                success: function () {
                    gotoPage('student/sWork.php');
                }
            });
            return false; //阻止表单跳转
        });

    });

    layui.use('upload', function () {
        let $ = layui.jquery
            , upload = layui.upload;
        let demoListView = $('#demoList')
            , uploadListIns = upload.render({
            elem: '#testList'
            , url: './php/upload.php'
            , accept: 'file'
            , data: {
                content: function () {
                    return $('#workContent').val();
                }
            }
            , multiple: true
            , auto: false
            , bindAction: '#upload'
            , choose: function (obj) {
                let files = obj.pushFile(); //将每次选择的文件追加到文件队列


                //读取本地文件
                obj.preview(function (index, file) {
                    let tr = $(['<tr id="upload-' + index + '">'
                        , '<td id="fileName">' + file.name + '</td>'
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
            , done: function (res, index) {
                if (res.code === 0) { //上传成功
                    let tr = demoListView.find('tr#upload-' + index)
                        , tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    // return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
            }
            , allDone: function (obj) { //当文件全部被提交后，才触发
                $('.layui-word-aux').append("执行完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");

                layer.msg("上传完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");
            }
        });
    });
</script>