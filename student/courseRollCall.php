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
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "SELECT  time,state FROM rollcall WHERE cid = $cid AND sid = $sid");
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
            </colgroup>
            <thead>
            <tr>
                <th>点名时间</th>
                <th>出勤状态</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                ?>
                <tr>
                    <td><?php echo $row['time'] ?></td>
                    <td><?php
                        switch ($row['state']) {
                            case 'N':
                                echo '<span style="color: #00bbbd">✔已到</span>';
                                break;
                            case 'L':
                                echo '<span style="color: #FFD700">○迟到</span>';
                                break;
                            case 'A':
                                echo '<span style="color: #FF8C00">△请假</span>';
                                break;
                            case 'T':
                                echo '<span style="color: #8B0000">×旷课</span>';
                                break;
                        }
                          ?></td>
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
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>
