<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 21:09
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$rs = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type = 'T'");
$count = mysqli_num_rows($rs);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>课程章节</cite></a>
        </span>
    </div>
    <?php
    if ($count > 0) { ?>
        <div class="layui-collapse" lay-filter="test">
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $number = $row['number'];
                $chid = $row['chid'];
                $rs1 = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type != 'T' AND number = $number")
                ?>
                <div class="layui-colla-item">
                    <h3 class="layui-colla-title">第<?php echo $number ?>章 <?php echo $row['title'] ?></h3>
                    <div class="layui-colla-content layui-show">
                        <?php while ($row1 = mysqli_fetch_assoc($rs1)) { ?>
                            <h2 class="link" id="item" style="margin-bottom: 5px"
                                onclick="gotoPage('student/chapterItem.php?chid=<?php echo $row1['chid'] ?>')">
                                <img src="icon/<?php
                                switch ($row1['type']) {
                                    case 'A':
                                        echo 'attachment.png';
                                        break;
                                    case 'K':
                                        echo 'link.png';
                                        break;
                                }
                                ?>" class="layui-nav-img"><?php echo $row1['title'] ?></h2>
                        <?php }
                        $rs1 = mysqli_query($conn, "SELECT * FROM work_t WHERE cid = cid AND chid = $chid");
                        while ($row1 = mysqli_fetch_assoc($rs1)) {
                            ?>
                            <h2 class="link" style="margin-bottom: 5px" onclick="gotoPage('student/work.php?wtid=<?php echo $row1['wtid'] ?>')">
                                <img src="icon/work.png" class="layui-nav-img"><?php echo $row1['title'] ?>
                            </h2>
                            <?php
                        }
                        $rs1 = mysqli_query($conn, "SELECT * FROM discass_t WHERE cid = cid AND chid = $chid");
                        while ($row1 = mysqli_fetch_assoc($rs1)) {
                            ?>
                            <h2 class="link" style="margin-bottom: 5px" onclick="gotoPage('student/discuss.php?dtid=<?php echo $row1['dtid'] ?>')">
                                <img src="icon/disscuss.png" class="layui-nav-img"><?php echo $row1['title'] ?>
                            </h2>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            } ?>
        </div>
        <?php
    } else {
        ?>
        <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无章节</p>
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
</script
