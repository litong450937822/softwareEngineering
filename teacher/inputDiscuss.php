<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 17:45
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/sWork.php')">作业</a>
            <a><cite>添加作业</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="work">
        <div class="layui-form-item">
            <label class="layui-form-label">讨论题目</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                       class="layui-input">
            </div>
        </div>
        <button class="layui-btn " lay-submit="" lay-filter="insertDiscuss" id="submit">提交</button>
    </form>
</div>

<script>


    layui.use(['element','form'], function () {
        let element = layui.element //导航的hover效果、二级菜单等功能，需要依赖element模块
            ,form = layui.form;

        element.render();

        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '标题不得少于5个字符';
                }
            }
        });

        form.on('submit(insertDiscuss)', function (data) {
            $.ajax({
                url: './php/addDiscuss.php',
                type: 'post',
                data: data.field
            });
            gotoPage('teacher/courseDiscuss.php');
            return false; //阻止表单跳转
        });
    });
</script>
