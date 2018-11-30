<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/17
 * Time: 13:55
 */
require_once("../connect/conn.php");
session_start();
$class = $_SESSION['clid'];
$rs = mysqli_query($conn, "select * from course left join teacher on course.tid = teacher.tid 
where clid = $class");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <ol class="breadcrumb">
        <li class="active">课程选择</li>
    </ol>
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="50">
            <col width="600">
            <col width="100">
        </colgroup>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($rs)) {
            ?>
            <tr onclick="selectCourse(<?php echo $row['cid'] ?>)" class="link">
                <td><img src="./img/course-cover-default.png" style="width: 130px; height: 71px"></td>
                <td><p style="font-size: 20px"><?php echo $row['courseName'] ?></p>
                    <p>开课日期：<?php echo $row['startDate']  ?> - 课程结束日期：<?php echo $row['endDate']  ?></p>
                    <p>任课教师：<?php echo $row['name'] ?></p>
                </td>
                <td><?php echo $row['semester'] ?></td>
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

        //监听导航点击
        element.on('nav(demo)', function (elem) {
            //console.log(elem)
            layer.msg(elem.text());
        });
    });

    function selectCourse(cid) {
        $('#left_menu').show();
        gotoPage('student/description.php?cid='+cid);
    }
</script>