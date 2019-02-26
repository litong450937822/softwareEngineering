<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/25
 * Time: 21:23
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a onclick="backToSelect('t')">课程选择</a>
            <a onclick="gotoPage('teacher/sWork.php')">作业</a>
            <a><cite>添加作业</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="work">
        <div class="layui-form-item">
            <label class="layui-form-label">作业标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">起始时间</label>
                <div class="layui-input-block">
                    <input type="text" name="startTime" id="startTime" autocomplete="off" lay-verify="required"
                           value="<?php echo date('Y/m/d h:i:s'); ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="endTime" id="endTime" autocomplete="off" lay-verify="endTime"
                           class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">作业内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="content" lay-verify="required"
                          class="layui-textarea"></textarea>
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
            <button class="layui-btn " lay-submit="" lay-filter="insertWork" id="submit">提交</button>
        </div>
    </form>
</div>

<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        let form = layui.form
            , layer = layui.layer
            , laydate = layui.laydate;

        form.render();
        //日期
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
                    return '标题至少得5个字符啊';
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

        form.on('submit(insertWork)', function(data){
            if ($('#fileName').text() == null){
                $.ajax({
                    url: './php/insertWork.php',
                    type: 'post',
                    data: data.field
                });
                gotoPage('teacher/sWork.php');
            }
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
        let str = '';
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
            , bindAction: '#submit'
            , choose: function (obj) {
                let files = obj.pushFile(); //将每次选择的文件追加到文件队列


                //读取本地文件
                obj.preview(function (index, file) {
                    str += file.name + ';';
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
                let content = $('textarea[name="content"]').val()
                    , title = $('input[name="title"]').val()
                    , startTime = $('input[name="startTime"]').val()
                    , endTime = $('input[name="endTime"]').val();
                str = str.substr(0, str.length - 1);
                let data = {
                    title: title
                    , startTime: startTime
                    , endTime: endTime
                    , content: content
                    , file: str
                };
                $.ajax({
                    url: './php/insertWork.php',
                    type: 'post',
                    data: data
                });
                layer.msg("上传完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");
                setTimeout(function () {
                    gotoPage('teacher/sWork.php')
                }, 2000);
            }
        });
    });
</script>