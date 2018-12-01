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
$sid = @$_SESSION['id'];
$rs = mysqli_query($conn, "select * from work_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <ol class="breadcrumb">
        <li onclick="backToSelect()" class="link">课程选择</li>
        <li class="active">作业</li>
    </ol>
    <table class="layui-table" lay-skin="line" style="margin: auto">
        <colgroup>
            <col width="400px">
            <col width="150px">
            <col width="300px">
        </colgroup>
        <thead>
        <tr>
            <th>作业名称</th>
            <th>状态</th>
            <th>成绩</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($rs)) {
            $wtid = $row['wtid'];
            $rs1 = mysqli_query($conn, "Select * from work_s where sid = $sid and wtid = $wtid");
            ?>
            <tr class="work link" data-wtid="<?php echo $row['wtid'] ?>">
                <td><?php echo $row['title'] ?></td>
                <?php
                if (mysqli_num_rows($rs1) >= 1) {
                    $row1 = mysqli_fetch_assoc($rs1)
                    ?>
                    <td><p style="color: #009688">已交</p></td>
                    <td><p style="color: #009688"><?php echo $row1['score'] ?></p></td>
                    <?php
                } else {
                    ?>
                    <td><p style="color: #ff5722">未交</p></td>
                    <td><p style="color: #009688">0</p></td>
                    <?php
                }
                ?>
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
        gotoPage('student/work.php?wtid='+wtid);
    })

</script>
