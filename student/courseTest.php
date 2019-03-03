<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/10
 * Time: 14:47
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$rs = mysqli_query($conn, "select * from test_t where cid = $cid");
$sid = $_SESSION['id'];
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a><cite>测试</cite></a>
        </span>
    </div>
    <?php
    if (mysqli_num_rows($rs) >= 1) {
        ?>
        <table class="layui-table" lay-skin="line" style="margin: auto">
            <colgroup>
                <col width="400px">
                <col width="150px">
                <col width="300px">
            </colgroup>
            <thead>
            <tr>
                <th>测验名称</th>
                <th>状态</th>
                <th>成绩</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $ttid = $row['ttid'];
                $rs1 = mysqli_query($conn, "Select * from test_s where sid = $sid and ttid = $ttid");
                ?>
                <tr>
                    <td class="test link" data-ttid="<?php echo $row['ttid'] ?>">
                        <?php echo $row['title'] ?></td>
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
        <?php
    } else {
        ?>
        <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无测试</p>
        </div>
        <?php
    }
    ?>
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    $('.test').on('click', function () {
        let ttid = $(this).data('ttid');
        gotoPage('student/test.php?ttid=' + ttid);
    })
</script>