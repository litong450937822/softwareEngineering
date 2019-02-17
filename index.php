<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>《软件工程》学生学习效果跟踪系统</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/test.js"></script>
    <script src="layui/layui.all.js"></script>
    <script type="text/javascript" src="js/wangEditor.min.js"></script>
    <script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <style>
        .link {
            cursor: pointer
        }
    </style>
    <script language="JavaScript">

        $(function () {
            <?php if ($_SESSION['identity'] == 's' ){?>
            $('#content').load('student/CourseSelection.php');
            $('#menu').load('navigation/studentMenu.html');
            <?php }else { ?>
            $('#content').load('teacher/CourseSelection.php');
            $('#menu').load('navigation/teacherMenu.html');
            <?php } ?>
            $('#left_menu').hide();
        });

        <?php
        echo 'let id=' . $_SESSION['id'];
        ?>

        function backToSelect() {
            $('#content').load('student/CourseSelection.php');
            $('#left_menu').hide();
        }

        function gotoPage(page) {
            $('#content').load(page);
            return false;
        }

        function changeMenu(page) {
            $('#menu').load(page);
            return false;
        }
    </script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">《软件工程》课程管理</div>
        <!-- 头部区域-->
        <?php
        if ($_SESSION['identity'] == 't') {
        ?>
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item"><a href="javascript:" onclick="changeMenu('navigation/teacherMenu.html');
                                              gotoPage('teacher/concernUser.php')">课程管理</a>
                </li>
                <li class="layui-nav-item"><a href="javascript:" onclick="changeMenu('navigation/managerMenu.html');
                                              gotoPage('manager/manageStudents.php')">学习效果跟踪</a></li>
            </ul>
        <?php
        }
        ?>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:">
                    <img src="img/default.jpg" class="layui-nav-img">
                    <?php echo $_SESSION['name'] ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="php/logout.php">注销</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black" id="left_menu">
        <div class="layui-side-scroll" id="menu">
            <!-- 左侧导航区域-->

        </div>
    </div>

    <div class="layui-body" id="content">

    </div>

    <div class="layui-footer">
        © 《软件工程》课程学生学习效果追踪系统——2018西安欧亚学院—软件工程1502李曈
    </div>
</div>

</body>
</html>

