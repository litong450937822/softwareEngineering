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
$rs = mysqli_query($conn, "select * from question_t where cid = $cid");
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>问卷调查</cite></a>
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
                <th>问卷名称</th>
                <th style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                ?>
                <tr>
                    <td class="question link" data-qtid="<?php echo $row['qtid'] ?>"><?php echo $row['title'] ?></td>
                    <td style="text-align: center">
                        <button class="layui-btn layui-btn-sm"
                                onclick="editQuestion(<?php echo $row['qtid'] ?>)">
                            <i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-sm delQuestionnaire" data-method="confirmTrans" id="work"
                                data-title="<?php echo $row['title'] ?>"
                                data-qtid="<?php echo $row['qtid'] ?>">
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
    <div style="width: auto; margin: auto;" align="center">
    <button class="layui-btn" style="margin-top: 20px"
            onclick="gotoPage('teacher/inputQuestionnaire.php')">
        <i class="layui-icon">&#xe608;</i> 添加
    </button>
    </div>
</div>

<script>
    $('.question').on('click', function () {
        let qtid = $(this).data('qtid');
        gotoPage('teacher/questionCompletion.php?qtid=' + qtid);
    });

    function editQuestion(qtid) {
        gotoPage('teacher/inputQuestionnaire.php?qtid=' + qtid);
    }

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
    //触发事件
    active = {
        confirmTrans: function (othis) {
            let title = othis.data('title');
            let qtid = othis.data('qtid');
            //配置一个透明的询问框
            layer.msg('确认删除' + title + '吗？', {
                time: 20000, //20s后自动关闭
                btn: ['确认', '退出']
                , btn1: function () {
                    $.ajax({
                        type: "POST",
                        url: "./php/deleteQuestionnaire.php",//url
                        data: {
                            qtid: qtid,
                        },
                        success: function () {
                            layer.msg('刪除成功');
                            gotoPage('teacher/courseQuestionnaire.php');
                        }
                    });
                    layer.closeAll();
                }
            })

        }
    };

    $('.delQuestionnaire').on('click', function () {
        let othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
    });
</script>