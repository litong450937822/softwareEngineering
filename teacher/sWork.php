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
        <li onclick="backToSelect('s')" class="link">课程选择</li>
        <li class="active">作业</li>
    </ol>
    <table class="layui-table" lay-skin="line" style="margin: auto">
        <colgroup>
            <col width="550px">
            <col width="300px">
        </colgroup>
        <thead>
        <tr>
            <th>作业名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($rs)) {
            ?>
            <tr class="work link" data-wtid="<?php echo $row['wtid'] ?>">
                <td><?php echo $row['title'] ?></td>
                    <td><button class="layui-btn layui-btn-sm"><i class="layui-icon"></i></button>
                        <button class="layui-btn layui-btn-sm"><i class="layui-icon"></i></button></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    $('.work').on('click', function () {
        let wtid = $(this).data('wtid');
        gotoPage('student/work.php?wtid=' + wtid);
    })

</script>
