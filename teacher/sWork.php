<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/16
 * Time: 20:58
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$_SESSION['cid'] = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$rs = mysqli_query($conn, "select * from work_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>作业</cite></a>
        </span>
    </div>
    <?php
    if (mysqli_num_rows($rs) >= 1) {
    ?>
    <table class="layui-table" lay-skin="line" style="margin: auto">
        <colgroup>
            <col width="550px">
            <col width="70px">
        </colgroup>
        <thead>
        <tr>
            <th>作业名称</th>
            <th style="text-align: center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($rs)) {
            ?>
            <tr>
                <td class="work link" data-wtid="<?php echo $row['wtid'] ?>"><?php echo $row['title'] ?></td>
                <td style="text-align: center">
                    <button class="layui-btn layui-btn-sm"
                            onclick="editWork(<?php echo $row['wtid'] ?>)">
                        <i class="layui-icon">&#xe642;</i></button>
                    <button class="layui-btn layui-btn-sm work" data-method="confirmTrans" id="work"
                            data-title="<?php echo $row['title'] ?>"
                            data-wtid="<?php echo $row['wtid'] ?>">
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
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无作业</p>
        </div>
        <?php
    }
    ?>
    <button class="layui-btn layui-col-md-offset5" style="margin-top: 20px" onclick="gotoPage('teacher/inputWork.php')">
        <i class="layui-icon">&#xe608;</i> 添加
    </button>
</div>
<script>
    $('.work').on('click', function () {
        let wtid = $(this).data('wtid');
        gotoPage('teacher/workCompletion.php?wtid=' + wtid);
    });

    function editWork(wtid) {

    }

    layui.use('layer', function () { //独立版的layer无需执行这一句
        let $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句

        //触发事件
        let active = {
            confirmTrans: function (othis) {
                let title = othis.data('title');
                let wtid = othis.data('wtid');
                //配置一个透明的询问框
                layer.msg('确认删除' + title + '吗？', {
                    time: 20000, //20s后自动关闭
                    btn: ['确认', '退出']
                    , btn1: function () {
                        $.ajax({
                            type: "POST",
                            url: "./php/deleteWork.php",//url
                            data: {
                                wtid: wtid,
                            },
                        });
                        layer.closeAll();
                        setTimeout(function () {
                            gotoPage('teacher/sWork.php')
                        }, 500);
                        layer.msg('刪除成功');
                    }
                })

            }
        };

    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>
