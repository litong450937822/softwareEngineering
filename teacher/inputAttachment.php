<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/19
 * Time: 23:39
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$number = $_GET['number'];
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseChapter.php')">课程章节</a>
            <a><cite>添加附件</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="work">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="required"
                       class="layui-input">
            </div>
        </div>
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
        </div>
        <div class="layui-form-item">
            <button type="button" class="layui-btn" id="testList">选择文件</button>
            <button type="button" class="layui-btn" id="upload">上传文件</button>
        </div>
        <button class="layui-btn " lay-submit="" lay-filter="addAttachment" id="submit">提交</button>
    </form>
</div>

<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        let form = layui.form
            , layer = layui.layer;

        form.render();

        form.on('submit(addAttachment)', function (data) {
            let fileStr = '';
            $('td#fileName').each(function () {
                fileStr += $(this).text() + ';';
            });
            fileStr = fileStr.substr(0, fileStr.length - 1);
            data.field.file = fileStr;
            data.field.number = '<?php echo $number ?>';
            $.ajax({
                url: './php/addAttachment.php',
                type: 'post',
                data: data.field,
                success: function () {
                    gotoPage('teacher/courseChapter.php');
                }
            });
            return false; //阻止表单跳转
        });

    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
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
                }
            }
            , allDone: function (obj) { //当文件全部被提交后，才触发
                $('.layui-word-aux').append("执行完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");

                layer.msg("上传完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");
            }
        });
    });
</script>
