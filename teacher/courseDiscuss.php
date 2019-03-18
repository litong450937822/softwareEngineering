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
            <a class="link" onclick="backToSelect('t')">课程选择</a>
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
                <col width="100px">
            </colgroup>
            <thead>
            <tr>
                <th>讨论主题</th>
                <th>回复数</th>
                <th>访问量</th>
                <th>最后更新</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $dtid = $row['dtid'];
                $rs1 = mysqli_query($conn, "select * from discass_s where dtid = $dtid");
                $recordCount = mysqli_num_rows($rs1);
                ?>
                <tr>
                    <td class="link discuss" data-dtid="<?php echo $row['dtid'] ?>"><?php echo $row['title'] ?></td>
                    <td class="link discuss" data-dtid="<?php echo $row['dtid'] ?>"><?php echo $recordCount ?></td>
                    <td class="link discuss" data-dtid="<?php echo $row['dtid'] ?>"><?php echo $row['traffic'] ?></td>
                    <td class="link discuss"
                        data-dtid="<?php echo $row['dtid'] ?>"><?php echo $row['lastUpdateTime'] ?></td>
                    <td>
                        <button class="layui-btn layui-btn-sm delDiscuss" data-method="confirmTrans" id="discuss"
                                data-title="<?php echo $row['title'] ?>"
                                data-dtid="<?php echo $row['dtid'] ?>">
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
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无讨论主题</p>
        </div>
        <?php
    }
    ?>
    <div style="width: auto; margin: auto;" align="center">
    <button class="layui-btn" style="margin-top: 20px"
            onclick="gotoPage('teacher/inputDiscuss.php')">
        <i class="layui-icon">&#xe608;</i> 添加
    </button>
    </div>
</div>
<script>
    active = {
        confirmTrans: function (othis) {
            let title = othis.data('title');
            let dtid = othis.data('dtid');
            //配置一个透明的询问框
            layer.msg('确认删除' + title + '吗？', {
                time: 20000, //20s后自动关闭
                btn: ['确认', '退出']
                , btn1: function () {
                    $.ajax({
                        type: "POST",
                        url: "./php/deleteDiscuss_t.php",//url
                        data: {
                            dtid: dtid,
                        },
                        success: function () {
                            gotoPage('teacher/courseDiscuss.php');
                            layer.msg('刪除成功');
                        }
                    });
                    layer.closeAll();

                }
            })

        }
    };
    $('.delDiscuss').on('click', function () {
        let othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
    });

    $('.discuss').on('click', function () {
        let dtid = $(this).data('dtid');
        gotoPage('teacher/discuss.php?dtid=' + dtid);
    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script>