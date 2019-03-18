<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/5
 * Time: 21:04
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$qtid = @$_GET['qtid'];
if ($qtid != null) {
    $rs = mysqli_query($conn, "SELECT * FROM question_t WHERE qtid = $qtid");
    $row = mysqli_fetch_assoc($rs);
}
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseQuestionnaire.php')">问卷</a>
            <a><cite><?php
                    if ($qtid != null)
                        echo '编辑问卷';
                    else
                        echo '添加问卷';
                    ?></cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="test">
        <div class="layui-form-item">
            <label class="layui-form-label">问卷标题</label>
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
                           value="<?php if ($qtid != null)
                               echo $row['startTime'];
                           else
                               echo date('Y/m/d h:i:s'); ?>" class="layui-input">
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
        <div id="question">
            <?php if ($qtid != null) {
                $rs1 = mysqli_query($conn, "SELECT * FROM question_q WHERE qtid = $qtid GROUP BY number");
                $number = 1;
                while ($row1 = mysqli_fetch_assoc($rs1)) {
                    ?>
                    <div class='layui-form-item' id='question<?php echo $number ?>'>
                        <label class="layui-form-label">问题<?php echo $number ?></label>
                        <div class="layui-input-block">
                            <input type="text" name="question<?php echo $number ?>" autocomplete="off"
                                   placeholder="请输入问题" lay-verify="required" class="layui-input"
                                   value="<?php echo $row1['question'] ?>">
                        </div>
                    </div>
                    <?php $number++;
                }
            } ?>
        </div>
        <div id="button" style="width: auto; margin: auto;" align="center"></div>
        <div style="width: auto; margin: auto;" align="center">
            <button class="layui-btn layui-btn-fluid layui-btn-primary"
                    id="addQuestion" ><i class="layui-icon">&#xe608;</i>添加问题
            <button class="layui-btn" lay-submit="" lay-filter="insertTest" id="submit" style="margin-top: 20px">提交
            </button>
        </div>
    </form>
</div>

<script>
    questionID = <?php echo @is_null(@$number) ? 1 : $number; ?>;

    $(function () {
        if (questionID > 1)
            $('#button').append("<button class=\"layui-btn layui-btn-fluid layui-btn-primary\"  type=\"button\" " +
                "id=\"del\" onclick='delQuestion()' style='margin-bottom: 10px'><i class=\"layui-icon\">&#x1007;</i>删除题目\n" +
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

        $('#addQuestion').on('click', function () {
            let question = $("#question");
            question.show();
            question.append("<div class='layui-form-item' id='question" + questionID + "' >" +
                "<label class=\"layui-form-label\">问题" + questionID + "</label>\n" +
                "<div class=\"layui-input-block\">\n" +
                "<input type=\"text\" name=\"question" + questionID + "\" autocomplete=\"off\" " +
                "placeholder=\"请输入问题\" lay-verify=\"required\" class=\"layui-input\">\n" +
                "</div>\n" +
                "</div>");
            if (questionID === 1) {
                $('#button').append("<button class=\"layui-btn layui-btn-fluid layui-btn-primary\"  type=\"button\" " +
                    "id=\"del\" onclick='delQuestion()' style='margin-bottom: 10px'><i class=\"layui-icon\">&#x1007;</i>删除题目\n" +
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
            if (questionID === 1) {
                $('#question').hide();
                $('#delQuestion').remove();
            }
            return false; //阻止表单跳转
        });

        form.on('submit(insertTest)', function (data) {
            qtid = '<?php echo @$qtid; ?>';
            data.field.qtid = qtid;
            $.ajax({
                url: './php/insertQuestionnaire.php',
                type: 'post',
                data: data.field,
                success: function (data) {
                    if (qtid === '')
                        layer.msg('添加测验成功，共' + data + '道题目');
                    else
                        layer.msg('修改测验成功，共' + data + '道题目');
                    gotoPage('teacher/courseQuestionnaire.php');
                }
            });
            return false; //阻止表单跳转
        });
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    function delQuestion() {
        let div = 'question' + (questionID - 1);
        $("#" + div).remove();
        questionID--;
        if (questionID === 1)
            $('#del').remove();
    }
</script>