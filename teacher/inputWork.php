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
            <label class="layui-form-label">长输入框</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">短输入框</label>
            <div class="layui-input-inline">
                <input type="text" name="username" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">日期选择</label>
                <div class="layui-input-block">
                    <input type="text" name="date" id="date1" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">行内表单</label>
                <div class="layui-input-inline">
                    <input type="text" name="number" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请务必填写用户名</div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">范围</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">-</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">单行选择框</label>
            <div class="layui-input-block">
                <select name="interest" lay-filter="aihao">
                    <option value=""></option>
                    <option value="0">写作</option>
                    <option value="1" selected="">阅读</option>
                    <option value="2">游戏</option>
                    <option value="3">音乐</option>
                    <option value="4">旅行</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">行内选择框</label>
            <div class="layui-input-inline">
                <select name="quiz1">
                    <option value="">请选择省</option>
                    <option value="浙江" selected="">浙江省</option>
                    <option value="你的工号">江西省</option>
                    <option value="你最喜欢的老师">福建省</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="quiz2">
                    <option value="">请选择市</option>
                    <option value="杭州">杭州</option>
                    <option value="宁波" disabled="">宁波</option>
                    <option value="温州">温州</option>
                    <option value="温州">台州</option>
                    <option value="温州">绍兴</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="quiz3">
                    <option value="">请选择县/区</option>
                    <option value="西湖区">西湖区</option>
                    <option value="余杭区">余杭区</option>
                    <option value="拱墅区">临安市</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">开关-开</label>
            <div class="layui-input-block">
                <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" title="开关">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">单选框</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="男" title="男" checked="">
                <input type="radio" name="sex" value="女" title="女">
                <input type="radio" name="sex" value="禁" title="禁用" disabled="">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">文本域</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <label class="layui-form-label">选择框</label>
        <div class="layui-input-block">
            <select name="city" lay-verify="required">
                <option value=""></option>
                <option value="0">北京</option>
                <option value="1">上海</option>
                <option value="2">广州</option>
                <option value="3">深圳</option>
                <option value="4">杭州</option>
            </select>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="demo2">跳转式提交</button>
        </div>
    </form>
</div>

<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;

        form.render();
        //日期
        laydate.render({
            elem: '#date'
        });
        laydate.render({
            elem: '#date1'
        });

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 5){
                    return '标题至少得5个字符啊';
                }
            }
            ,pass: [
                /^[\S]{6,12}$/
                ,'密码必须6到12位，且不能出现空格'
            ]
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });

        //监听提交
        form.on('submit(demo1)', function(data){
            layer.alert(JSON.stringify(data.field), {
                title: '最终的提交信息'
            });
            return false;
        });

    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>