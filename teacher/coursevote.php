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
$rs = mysqli_query($conn, "select * from vote_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>课程投票</cite></a>
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
                <th>投票名称</th>
                <th style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                ?>
                <tr>
                    <td class="vote link" data-vtid="<?php echo $row['vtid'] ?>"><?php echo $row['title'] ?></td>
                    <td style="text-align: center">
                        <button class="layui-btn layui-btn-sm"
                                onclick="editVote(<?php echo $row['vtid'] ?>)">
                            <i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-sm delVote" data-method="confirmTrans" id="vote"
                                data-title="<?php echo $row['title'] ?>"
                                data-vtid="<?php echo $row['vtid'] ?>">
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
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无问卷</p>
        </div>
        <?php
    }
    ?>
    <button class="layui-btn layui-col-md-offset5" style="margin-top: 20px"
            onclick="gotoPage('teacher/inputVote.php')">
        <i class="layui-icon">&#xe608;</i> 添加
    </button>
</div>

<script>
    $('.vote').on('click', function () {
        let vtid = $(this).data('vtid');
        gotoPage('teacher/voteCompletion.php?vtid=' + vtid);
    });

    function editVote(vtid) {
        gotoPage('teacher/inputVote.php?vtid=' + vtid);
    }

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
    //触发事件
    active = {
        confirmTrans: function (othis) {
            let title = othis.data('title');
            let vtid = othis.data('vtid');
            //配置一个透明的询问框
            layer.msg('确认删除' + title + '吗？', {
                time: 20000, //20s后自动关闭
                btn: ['确认', '退出']
                , btn1: function () {
                    $.ajax({
                        type: "POST",
                        url: "./php/deleteVote.php",//url
                        data: {
                            qtid: qtid,
                        },
                        success: function () {
                            layer.msg('刪除成功');
                            gotoPage('teacher/courseVote.php');
                        }
                    });
                    layer.closeAll();
                }
            })

        }
    };

    $('.delVote').on('click', function () {
        let othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
    });
</script>