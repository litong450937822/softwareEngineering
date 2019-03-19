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
            <a><cite>添加链接</cite></a>
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
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">网页地址</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入链接" name="link" lay-verify="required"
                          class="layui-textarea">http://</textarea>
            </div>
        </div>
        <div align="center">
        <button class="layui-btn " type="button" id="test">测试</button>
        <button class="layui-btn " lay-submit="" lay-filter="addLink" id="submit">提交</button>
        </div>
    </form>
</div>

<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        let form = layui.form
            , layer = layui.layer;

        form.render();

        $('#test').on('click', function () {
            let url = $('textarea[name="link"]').val();
            window.open(url, "_blank");
        });
        
        form.on('submit(addLink)', function (data) {
            let fileStr = '';
            $('td#fileName').each(function () {
                fileStr += $(this).text() + ';';
            });
            fileStr = fileStr.substr(0, fileStr.length - 1);
            data.field.file = fileStr;
            data.field.number = '<?php echo $number ?>';
            $.ajax({
                url: './php/addLink.php',
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
</script>
