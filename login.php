<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登陆|《软件工程》学生学习效果跟踪系统</title>
    <link rel="stylesheet" href="layui/css/layui.css">
</head>
<style>
    html,body {
        height: 100%;
    }
    body{
        background: url("img/timg.jpg") no-repeat center center;
    }
<body>
</style>
<div class="login-main" style="width: 320px; height: 100%; background: rgba(238,238,238,0.7); float: right; margin-right: 20% ">
    <form class="layui-form layui-form-pane" action="php/login.php" method="post" style="width: 300px;margin: 0 auto auto ">
        <p style="width: 110px; margin: 0 auto auto; color: orange"><?PHP
            if (isset($_SESSION['error'])){
                echo  '<script>alert("'.$_SESSION['error'].'");</script>';
                unset($_SESSION['error']);
            }
            ?></p>
        <div class="layui-form-item" style="margin: 300px auto auto;">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="schoolNumber" lay-verify="required" placeholder="请输入学工号" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="margin: 10px auto auto">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 10px">
            <button class="layui-btn layui-btn-danger layui-btn-fluid" lay-submit="" lay-filter="demo2">登陆</button>
        </div>
    </form>
    <div style="width: 280px; margin: 300px auto auto">
        <p>&copy;2018西安欧亚学院—软件工程1502李曈</p>
    </div>
</div>
<script src="layui/layui.js"></script>
</body>
</html>
