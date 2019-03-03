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
$sid = @$_SESSION['id'];
$rs = mysqli_query($conn, "select * from work_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a><cite>作业</cite></a>
        </span>
    </div>
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
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    $('.work').on('click', function () {
        let wtid = $(this).data('wtid');
        gotoPage('student/work.php?wtid=' + wtid);
    })

</script>
