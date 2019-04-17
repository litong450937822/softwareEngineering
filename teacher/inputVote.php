<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/5
 * Time: 21:04
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$vtid = @$_GET['vtid'];
if ($vtid != null) {
    $rs = mysqli_query($conn, "SELECT * FROM vote_t WHERE vtid = $vtid");
    $row = mysqli_fetch_assoc($rs);
}
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseVote.php')">课程投票</a>
            <a><cite><?php
                    if ($vtid != null)
                        echo '编辑投票';
                    else
                        echo '添加投票';
                    ?></cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="test">
        <div class="layui-form-item">
            <label class="layui-form-label">投票标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                       class="layui-input" value="<?php echo @$row['title'] ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label for="startTime" class="layui-form-label">起始时间</label>
                <div class="layui-input-block">
                    <input type="text" name="startTime" id="startTime" autocomplete="off" lay-verify="required"
                           value="<?php if ($vtid != null)
                               echo $row['startTime'];
                           else
                               echo date('Y/m/d H:i:s'); ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label for="endTime" class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="endTime" id="endTime" autocomplete="off" lay-verify="endTime"
                           class="layui-input" value="<?php echo @$row['endTime'] ?>">
                </div>
            </div>
        </div>
        <div id="option">
            <?php if ($vtid != null) {
                $option = explode(";", $row['options']);
                for ($i = 0; $i < count($option); $i++) {
                    ?>
                    <div class='layui-form-item' id='option<?php echo $i + 1 ?>'>
                        <label class="layui-form-label">选项<?php echo $i + 1 ?></label>
                        <div class="layui-input-block">
                            <input type="text" name="option<?php echo $i + 1 ?>" autocomplete="off"
                                   placeholder="请输入选项" lay-verify="required" class="layui-input"
                                   value="<?php echo $option[$i] ?>">
                        </div>
                    </div>
                    <?php
                }
            } ?>
        </div>
        <div id="button" style="width: auto; margin: auto;" align="center"></div>
        <div style="width: auto; margin: auto;" align="center">
            <button class="layui-btn layui-btn-fluid layui-btn-primary" type="button"
                    id="addOption"><i class="layui-icon">&#xe608;</i>添加选项
                <button class="layui-btn" lay-submit="" lay-filter="insertTest" id="submit" style="margin-top: 20px">提交
                </button>
        </div>
    </form>
</div>

<script>
    optionID = <?php echo @is_null(@$i) ? 1 : $i+1; ?>;

    $(function () {
        if (optionID > 1)
            $('#button').append("<button class=\"layui-btn layui-btn-fluid layui-btn-primary\"  type=\"button\" " +
                "id=\"del\" onclick='delOption()' style='margin-bottom: 10px'><i class=\"layui-icon\">&#x1007;</i>删除选项\n" +
                "</button>\n");
    });

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

        $('#addOption').on('click', function () {
            let option = $("#option");
            option.append("<div class='layui-form-item' id='option" + optionID + "'  >" +
                "<label class=\"layui-form-label\">选项" + optionID + "</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"option" + optionID + "\" autocomplete=\"off\" " +
                "placeholder=\"请输入选项\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "</div>");
            if (optionID === 1) {
                $('#button').append("<button class=\"layui-btn layui-btn-fluid layui-btn-primary\"  type=\"button\" " +
                    "id=\"del\" onclick='delOption()' style='margin-bottom: 10px'><i class=\"layui-icon\">&#x1007;</i>删除选项\n" +
                    "</button>\n");
            }
            form.render();
            optionID++;
            return false; //阻止表单跳转
        });

        form.on('submit(insertTest)', function (data) {
            vtid = '<?php echo @$vtid; ?>';
            data.field.vtid = vtid;
            $.ajax({
                url: './php/insertVote.php',
                type: 'post',
                data: data.field,
                success: function (data) {
                    if (vtid === '')
                        layer.msg('添加投票成功，共' + data + '个选项');
                    else
                        layer.msg('修改投票成功，共' + data + '个选项');

                    gotoPage('teacher/courseVote.php');
                }
            });
            return false; //阻止表单跳转
        });
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    function delOption() {
        let div = 'option' + (optionID - 1);
        $("#" + div).remove();
        optionID--;
        if (optionID === 1) {
            $('#del').remove();
        }
    }

</script>