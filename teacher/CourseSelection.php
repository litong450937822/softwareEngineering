<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/17
 * Time: 13:55
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$tid = $_SESSION['id'];
$rs = mysqli_query($conn, "select * from course left join class c on course.clid = c.clid 
where course.tid =  $tid");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a><cite>课程选择</cite></a>
        </span>
    </div>
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
            <tr onclick="selectCourse(<?php echo $row['cid'] ?>)" class="link" >
                <td><img src="./img/course-cover-default.png" style="width: 130px; height: 71px"></td>
                <td><p style="font-size: 20px"><?php echo $row['courseName'] ?></p>
                    <p>开课日期：<?php echo $row['startDate']  ?> - 课程结束日期：<?php echo $row['endDate']  ?></p>
                    <p>班级：<?php echo $row['className'] ?></p>
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

        element.render();
        //监听导航点击
        element.on('nav(demo)', function (elem) {
            //console.log(elem)
            layer.msg(elem.text());
        });
    });

    function selectCourse(cid) {
        changeMenu('navigation/teacherMenu.html');
        $('#left_menu').show();
        gotoPage('teacher/description.php?cid='+cid);
    }
</script>