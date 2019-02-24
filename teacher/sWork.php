<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/16
 * Time: 20:58
 */
require_once("../connect/conn.php");
session_start();
$cid = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$_SESSION['cid'] = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$rs = mysqli_query($conn, "select * from work_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <ol class="breadcrumb">
        <li onclick="backToSelect('t')" class="link">课程选择</li>
        <li class="active">作业</li>
    </ol>
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
            <tr class="work link" data-wtid="<?php echo $row['wtid'] ?>">
                <td><?php echo $row['title'] ?></td>
                <td style="text-align: center">
                    <button class="layui-btn layui-btn-sm"
                            onclick="editWork(<?php echo $row['wtid'] ?>)">
                        <i class="layui-icon">&#xe642;</i></button>
                    <button class="layui-btn layui-btn-sm work" data-method="confirmTrans" id="work"
                            data-title="<?php echo $row['title'] ?>">
                        <i class="layui-icon">&#xe640;</i></button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    // $('.work').on('click', function () {
    //     let wtid = $(this).data('wtid');
    //     gotoPage('student/work.php?wtid=' + wtid);
    // });

    function editWork(wtid) {

    }

    layui.use('layer', function () { //独立版的layer无需执行这一句
        let $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句

        //触发事件
        let active = {
            confirmTrans: function (othis) {
                let title = othis.data('title');
                //配置一个透明的询问框
                layer.msg('确认删除' + title + '吗？', {
                    time: 20000, //20s后自动关闭
                    btn: ['确认', '退出']
                });
            }

        };
        $('.work').on('click', function () {
            let othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        })
    });
</script>
