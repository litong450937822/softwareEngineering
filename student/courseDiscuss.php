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
$rs = mysqli_query($conn, "select * from discass_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('s')">课程选择</a>
            <a><cite>讨论</cite></a>
        </span>
    </div>
    <?php
    if (mysqli_num_rows($rs) >= 1) {
        ?>
        <table class="layui-table" lay-skin="line" style="margin: auto">
            <colgroup>
                <col width="400px">
                <col width="150px">
                <col width="150px">
                <col width="300px">
            </colgroup>
            <thead>
            <tr>
                <th>讨论主题</th>
                <th>回复数</th>
                <th>访问量</th>
                <th>最后更新</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $dtid = $row['dtid'];
                $rs1 = mysqli_query($conn, "select * from discass_s where dtid = $dtid");
                $recordCount = mysqli_num_rows($rs1);
                ?>
                <tr class="link discuss" data-dtid="<?php echo $row['dtid'] ?>">
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $recordCount ?></td>
                    <td><?php echo $row['traffic'] ?></td>
                    <td><?php echo $row['lastUpdateTime'] ?></td>
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
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无讨论主题</p>
        </div>
        <?php
    }
    ?>
</div>
<script>
    $('.discuss').on('click', function () {
        let dtid = $(this).data('dtid');
        gotoPage('student/discuss.php?dtid=' + dtid);
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>