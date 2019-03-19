<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 17:50
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$title = $_POST['title'];
$number = $_POST['number'];
$cid = $_SESSION['cid'];
$nowTime = date('Y/m/d H:i:s');
$file = $_POST['file'];
$sql = "INSERT INTO chapter(cid, number, title, type, content, time) VALUES ($cid,$number,'".$title."','A','".$file."','".$nowTime."')";
if ($conn->query($sql) === TRUE) {
    echo '添加成功';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
}