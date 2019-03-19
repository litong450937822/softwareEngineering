<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/19
 * Time: 20:40
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$number = $_POST['number'];
$title = $_POST['title'];
$cid = $_SESSION['cid'];
$nowTime = date('Y/m/d H:i:s');
$sql = "INSERT INTO chapter(cid, number, title, type,time) VALUES ($cid,$number,'" . $title . "','T','".$nowTime."')";
if ($conn->query($sql) === TRUE) {
    echo $sql;
    return 'success';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
    return 'error';
}