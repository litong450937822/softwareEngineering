<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/11/4
 * Time: 10:01
 */
require_once("../connect/conn.php");
session_start();
@$username = $_POST['schoolNumber'];
@$password = $_POST['password'];
$login_sql = "select * from student where schoolNumber = $username and password = '$password'";
$rs = mysqli_query($conn, $login_sql);
if (mysqli_num_rows($rs) >= 1) {
    $row = mysqli_fetch_assoc($rs);
    $_SESSION['id'] = $row['sid'];
    $_SESSION['identity'] = 's';
    $_SESSION['name'] = $row['name'];
    $sid= $row['sid'];
    $sql = "SELECT clid from class_s where sid = $sid";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rs);
    $_SESSION['clid'] = $row['clid'];
//    $_SESSION['schoolNumber'] = $username;
    header("location:../index.php");
} else {
    $login_sql = "select * from teacher where number = $username and password = '$password'";
    $rs = mysqli_query($conn, $login_sql);
    if (mysqli_num_rows($rs) >= 1) {
        $row = mysqli_fetch_assoc($rs);
        $_SESSION['id'] = $row['tid'];
        $_SESSION['identity'] = 't';
        $_SESSION['name'] = $row['name'];
//        $_SESSION['number'] = $username;
        header("location:../index.php");
    } else {
        $_SESSION['error'] = '用户名或密码错误';
//    $_SESSION['schoolNumber']=$username;
        header("location:../login.php");
    }
}
