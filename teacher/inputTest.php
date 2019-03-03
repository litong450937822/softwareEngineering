<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/2
 * Time: 22:52
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseTest.php')">测试</a>
            <a><cite>添加测试</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="test">
        <div class="layui-form-item">
            <label class="layui-form-label">测试标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label for="startTime" class="layui-form-label">起始时间</label>
                <div class="layui-input-block">
                    <input type="text" name="startTime" id="startTime" autocomplete="off" lay-verify="required"
                           value="<?php echo date('Y/m/d h:i:s'); ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label for="endTime" class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="endTime" id="endTime" autocomplete="off" lay-verify="endTime"
                           class="layui-input">
                </div>
            </div>
        </div>
        <div id="question"></div>
        <div id="button" style="width: auto; margin: auto;" align="center"></div>
        <div style="width: auto; margin: auto;" align="center">
            <button class="layui-btn layui-btn-fluid layui-btn-primary" lay-filter="addQuestion"
                    id="addQuestion" lay-submit=""
            "><i class="layui-icon">&#xe608;</i>添加题目
            <button class="layui-btn" lay-submit="" lay-filter="insertTest" id="submit" style="margin-top: 20px">提交
            </button>
        </div>
    </form>
</div>

<script>
    questionID = 1;

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

        form.on('submit(addQuestion)', function () {
            $('#question').append("<div style='border: #eee 1px solid;padding: 20px;margin-bottom: 20px;" +
                "height: auto' id='question" + questionID + "'>\n" +
                "<label class=\"layui-form-label\">问题" + questionID + "</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "\" autocomplete=\"off\" " +
                "placeholder=\"请输入问题\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "<label class=\"layui-form-label\">选项A</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "A\" autocomplete=\"off\"" +
                " placeholder=\"请输入选项A\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "<label class=\"layui-form-label\">选项B</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "B\" autocomplete=\"off\" " +
                "placeholder=\"请输入选项B\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "<label class=\"layui-form-label\">选项C</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "C\" autocomplete=\"off\" " +
                "placeholder=\"请输入选项C\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "<label class=\"layui-form-label\">选项D</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "D\" autocomplete=\"off\" " +
                "placeholder=\"请输入选项D\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "<label class=\"layui-form-label\">答案</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<select name=\"answer" + questionID + "\"  lay-verify=\"required\">\n" +
                "<option value=''></option>\n" +
                "<option value=\"A\">A</option>\n" +
                "<option value=\"B\" >B</option>\n" +
                "<option value=\"C\">C</option>\n" +
                "<option value=\"D\">D</option>\n" +
                "</select>\n" +
                "</div>" +
                "</div>");
            if (questionID === 1) {
                $('#button').append("<button class=\"layui-btn layui-btn-fluid layui-btn-primary\" lay-filter=\"delQuestion\"\n" +
                    "id=\"delQuestion\" lay-submit=\"\" style='margin-bottom: 10px' \"><i class=\"layui-icon\">&#x1007;</i>删除题目\n" +
                    "</button>\n")
            }
            form.render();
            questionID++;
            return false; //阻止表单跳转
        });

        form.on('submit(delQuestion)', function () {
            let div = 'question' + (questionID - 1);
            $("#" + div).remove();
            questionID--;
            if (questionID === 1)
                $('#delQuestion').remove();
            return false; //阻止表单跳转
        });

        form.on('submit(insertTest)', function (data) {
            $.ajax({
                url: './php/insertTest.php',
                type: 'post',
                data: data.field,
                success: function (data) {
                    layer.msg('添加作业成功，共' + data + '道题目');
                    gotoPage('teacher/courseTest.php');
                }
            });
            return false; //阻止表单跳转
        });
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

</script>