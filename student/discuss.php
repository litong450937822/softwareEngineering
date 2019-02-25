<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/27
 * Time: 0:31
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$id = $_SESSION['id'];
$dtid = $_GET['dtid'];
$rs = mysqli_query($conn, "select * from discass_s left join student on discass_s.sid = student.sid
 where dtid = $dtid");
$rs1 = mysqli_query($conn, "select * from discass_t where dtid = $dtid");
$row1 = mysqli_fetch_assoc($rs1);
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a onclick="backToSelect('s')">课程选择</a>
            <a onclick="gotoPage('student/courseDiscuss.php')">讨论</a>
            <a><cite><?php echo $row1['title'] ?></cite></a>
        </span>
    </div>
    <div style="background-color: #f5f5f5;border-radius: 3px;padding: 5px">
        <div style="background-color: #fff;border: 1px solid #eee;padding: 5px">
            <p style="font-size: 22px">讨论题目：<?php echo $row1['title'] ?></p>
            <p style="margin-top: 10px;">开始时间：<?php echo $row1['startTime'] ?></p>
            <p style="margin-top: 10px">最近一次回复时间：<?php echo $row1['lastUpdateTime'] ?></p>
        </div>
        <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
            <div style="background-color: #fff;border: 1px solid #eee;padding: 5px;margin-top: 5px">
                <table>
                    <colgroup>
                        <col width="150">
                        <col width="800">
                        <col width="50">
                    </colgroup>
                    <tr>
                        <td style="text-align: center">
                            <img src="img/default.jpg" class="layui-nav-img">
                            <p style="font-size: 22px"><?php echo $row['name'] ?></p>
                            <p style="margin-top: 10px"><?php echo $row['time'] ?></p>
                        </td>
                        <td style="padding-left: 20px"><p style="margin-top: 10px;"><?php echo $row['content'] ?></p>
                        </td>
                        <td id="delete">
                            <?php if ($id == $row['sid'])
                                echo '<i class="layui-icon link" onclick="deleteReply('.$row['dsid'].')" style="font-size:30px;">&#xe640;</i>';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>
        <fieldset style="margin-top: 30px;">
            <legend>回复</legend>
            <div class="layui-input-block" style="margin-left: 20px;margin-right: 20px">
                <textarea placeholder="请输入内容" class="layui-textarea" id="reply"></textarea>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <button class="layui-btn layui-col-md-offset5" onclick="reply()">回复</button>
            </div>
    </div>

</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    function reply() {
        let content = $('#reply').val();
        $.ajax({
            type: "POST",
            url: "./php/insertDiscuss.php",//url
            data: {
                id:<?php echo $id; ?>,
                dtid:<?php echo $dtid; ?>,
                content: content
            },
            success: function (result) {
                console.log(result);//打印服务端返回的数据(调试用)
                alert("回复成功");
                gotoPage('student/discuss.php?dtid=<?php echo $dtid; ?>');
            },
            error: function () {
                alert("回复失败");
            }
        });
    }

    function deleteReply(dsid) {
        $.ajax({
            type: "POST",
            url: "./php/deleteDiscuss.php",//url
            data: {
                dsid:dsid
            },
            success: function (result) {
                console.log(result);//打印服务端返回的数据(调试用)
                alert("删除成功");
                gotoPage('student/discuss.php?dtid=<?php echo $dtid; ?>');
            },
            error: function () {
                alert("删除失败");
            }
        })
    }
</script>