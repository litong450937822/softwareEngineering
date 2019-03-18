<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 18:45
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$clid = $_SESSION['clid'];
$time = @$_SESSION['time'];
@$_SESSION['time'] = null;
$rs = mysqli_query($conn, "SELECT sid,name FROM student WHERE clid = $clid");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/courseRollCall.php')">课程点名</a>
            <a><cite><?php
                    if ($time != null)
                        echo '编辑点名';
                    else
                        echo '添加点名';
                    ?></cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="test">

        <div class="layui-form-item">
            <!--            <div class="layui-inline">-->
            <label for="startTime" class="layui-form-label">点名时间</label>
            <div class="layui-input-block">
                <input type="text" name="rollCallTime" id="rollCallTime" autocomplete="off" lay-verify="required"
                       value="<?php if ($time != null)
                           echo $time;
                       else
                           echo date('Y/m/d h:i:s'); ?>" class="layui-input">
            </div>
            <!--            </div>-->
        </div>
        <table class="layui-table" lay-skin="line" style="margin: auto">
            <colgroup>
                <col width="400">
                <col width="300">
            </colgroup>
            <thead>
            <tr>
                <th>姓名</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($rs)) {
                $sid = $row['sid'];
                $state = '';
                if ($time != null) {
                    $rs1 = mysqli_query($conn, "SELECT * FROM rollcall WHERE sid = $sid");
                    $row1 = mysqli_fetch_assoc($rs1);
                    $state = $row1['state'];
                }
                ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td>
                                <input type="radio" name="<?php echo $sid ?>" value="N" title="已到"
                                    <?php if ($time == null || $state == 'N') echo 'checked'  ?>>
                                <input type="radio" name="<?php echo $sid ?>" value="L" title="迟到"
                                    <?php if ($state == 'L') echo 'checked'  ?>>
                                <input type="radio" name="<?php echo $sid ?>" value="A" title="请假"
                                    <?php if ($state == 'A') echo 'checked'  ?>>
                                <input type="radio" name="<?php echo $sid ?>" value="T" title="旷课"
                                    <?php if ($state == 'T') echo 'checked'  ?>>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div style="width: auto; margin: auto;" align="center">
            <button class="layui-btn" lay-submit="" lay-filter="insertTest" id="submit" style="margin-top: 20px">保存
            </button>
        </div>
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    layui.use(['form', 'layedit', 'laydate'], function () {
        let form = layui.form
            , layer = layui.layer
            , laydate = layui.laydate;

        form.render();
        //日期
        laydate.render({
            elem: '#rollCallTime'
            , type: 'datetime'
            , format: 'yyyy/MM/dd HH:mm:ss'
        });

        form.on('submit(insertTest)', function (data) {
            data.field.oldTime = '<?php echo @$time; ?>';
            $.ajax({
                url: './php/insertRollCall.php',
                type: 'post',
                data: data.field,
                success: function () {
                    layer.msg('保存成功');
                    gotoPage('teacher/courseRollCall.php');
                },
                error: function () {
                    layer.msg('保存失败');
                }
            });
            return false; //阻止表单跳转
        });
    });
</script>