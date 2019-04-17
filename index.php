<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>《软件工程》学生学习效果跟踪系统</title>
    <link rel="stylesheet" href="layui/css/layui.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="layui/layui.all.js"></script>
    <script src="js/echarts.min.js"></script>

    <style>
        .link {
            cursor: pointer
        }

        .content {
            border: #eee 1px solid;
            padding: 20px 20px 20px;
        }

        .question {
            border: #eee 1px solid;
            margin: 20px 20px 20px;
        }
    </style>
    <script language="JavaScript">
        function loginTime() {
            <?php if ($_SESSION['identity'] == 's') { ?>
            $.ajax({
                url: './php/loginTime.php',
                type: 'post',
            });
            <?php } ?>
        }

        $(function () {
            let content = $('#content');
            let menu = $('#menu');
            <?php if ($_SESSION['identity'] == 's' ){?>
            content.load('student/CourseSelection.php');
            menu.load('navigation/studentMenu.html');
            <?php }else { ?>
            content.load('teacher/CourseSelection.php');
            menu.load('navigation/teacherMenu.html');
            <?php } ?>
            $('#left_menu').hide();
            setInterval(loginTime, 30000);  //每30秒确认一次是否在线
        });

        <?php
        echo 'let id=' . $_SESSION['id'];
        ?>

        function backToSelect(identity) {
            if (identity === 's')
                $('#content').load('student/CourseSelection.php');
            else if (identity === 't')
                $('#content').load('teacher/CourseSelection.php');
            else
                $('#content').load('teacher/CourseSelection2.php');
            $('#left_menu').hide();
        }

        function gotoPage(page) {
            $('#content').load(page);
        }

        function changeMenu(page) {
            $('#menu').load(page);
            $('#left_menu').hide();
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
                                              gotoPage('teacher/CourseSelection.php')">课程管理</a>
                </li>
                <li class="layui-nav-item"><a href="javascript:" onclick="changeMenu('navigation/effectMenu.html');
                                              gotoPage('teacher/CourseSelection2.php')">学习效果跟踪</a></li>
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
</!DOCTYPE html>

