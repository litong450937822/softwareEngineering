<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 17:45
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$number = @$_GET['number'];
$cid = $_SESSION['cid'];
$rs1 = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type = 'T'");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <?php
            if ($number != null)
                echo '<a class="link" onclick="gotoPage(\'teacher/courseChapter.php\')">课程章节</a>';
            else
                echo '<a class="link" onclick="gotoPage(\'teacher/courseDiscuss.php\')">讨论</a>';
            ?>
            <a><cite>添加讨论</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane" action="" lay-filter="work">
        <div class="layui-form-item">
            <label class="layui-form-label">讨论题目</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-block" style="margin-bottom: 20px">
            <label class="layui-form-label">选择章节</label>
            <div class="layui-input-block" style="width: 200px">
                <select name="chid" data-number="<?php echo $number ?>" lay-verify="required">
                    <option value="">请选择章节</option>
                    <?php
                    while ($row1 = mysqli_fetch_assoc($rs1)) {
                        ?>
                        <option value="<?php echo $row1['chid'] ?>"><?php echo '第' . $row1['number'] . '章 ' . $row1['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <button class="layui-btn " lay-submit="" lay-filter="insertDiscuss" id="submit">提交</button>
    </form>
</div>

<script>


    layui.use(['element','form'], function () {
        let element = layui.element //导航的hover效果、二级菜单等功能，需要依赖element模块
            ,form = layui.form;

        element.render();
        form.render();
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '标题不得少于5个字符';
                }
            }
        });


        form.on('submit(insertDiscuss)', function (data) {
            $.ajax({
                url: './php/addDiscuss.php',
                type: 'post',
                data: data.field,
                success:function () {
                    gotoPage('teacher/courseDiscuss.php');
                }
            });
            return false; //阻止表单跳转
        });
    });
</script>
