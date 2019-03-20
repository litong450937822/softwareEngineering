<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 18:04
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$rs = mysqli_query($conn, "SELECT distinct time FROM rollcall WHERE cid = $cid");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>课程点名</cite></a>
        </span>
    </div>
    <?php
    if (mysqli_num_rows($rs) >= 1) {
        ?>
        <table class="layui-table" lay-skin="line" style="margin: auto">
            <colgroup>
                <col width="400px">
                <col width="100px">
                <col width="100px">
                <col width="100px">
                <col width="100px">
            </colgroup>
            <thead>
            <tr>
                <th>点名时间</th>
                <th>出勤人数</th>
                <th>请假人数</th>
                <th>旷课人数</th>
                <th style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $time = $row['time'];
                $rs1 = mysqli_query($conn, "SELECT * FROM rollcall WHERE cid = $cid AND time = '" . $time . "' AND (state = 'N' OR state = 'L')");
                $attendance = mysqli_num_rows($rs1);
                $rs1 = mysqli_query($conn, "SELECT * FROM rollcall WHERE cid = $cid AND time = '" . $time . "' AND state = 'A'");
                $leave = mysqli_num_rows($rs1);
                $rs1 = mysqli_query($conn, "SELECT * FROM rollcall WHERE cid = $cid AND time = '" . $time . "' AND state = 'T'");
                $truancy = mysqli_num_rows($rs1);
                ?>
                <tr>
                    <td><?php echo $time ?></td>
                    <td><?php echo $attendance ?></td>
                    <td><?php echo $leave ?></td>
                    <td><?php echo $truancy ?></td>
                    <td style="text-align: center">
                        <button class="layui-btn layui-btn-sm"
                                onclick="editRollCall('<?php echo $time ?>')">
                            <i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-sm delRollCall" data-method="confirmTrans"
                                data-time="<?php echo $time ?>">
                            <i class="layui-icon">&#xe640;</i></button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    } else {
        ?>
        <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无点名</p>
        </div>
        <?php
    }
    ?>
    <div style="width: auto; margin: auto;" align="center">
        <button class="layui-btn" style="margin-top: 20px"
                onclick="gotoPage('teacher/inputRollCall.php')">
            <i class="layui-icon">&#xe608;</i> 添加
        </button>
    </div>
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    function editRollCall(time) {
        $.ajax({
            type: "POST",
            url: "./php/postTime.php",
            data: {
                time: time
            },
            success: function () {
                gotoPage('teacher/inputRollCall.php');
            }
        });
    }

    active = {
        confirmTrans: function (othis) {
            let time = othis.data('time');
            //配置一个透明的询问框
            layer.msg('确认删除' + time + '的点名记录吗？', {
                time: 20000, //20s后自动关闭
                btn: ['确认', '退出']
                , btn1: function () {
                    $.ajax({
                        type: "POST",
                        url: "./php/deleteRollCall.php",//url
                        data: {
                            time: time,
                        },
                        success: function () {
                            gotoPage('teacher/courseRollCall.php');
                            layer.msg('刪除成功');
                        }
                    });
                    layer.closeAll();

                }
            })

        }
    };

    $('.delRollCall').on('click', function () {
        let othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
    });
</script>
