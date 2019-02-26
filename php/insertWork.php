<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/25
 * Time: 21:23
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$title = $_POST['title'];
$content = $_POST['content'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$cid = $_SESSION['cid'];
$file = @$_POST['file'];

$sql = "INSERT INTO work_t (title, cid, content, startTime, endTime, file) VALUE ('$title', $cid, '$content', '$startTime', '$endTime', '$file') ";

if (mysqli_query($conn, $sql)) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}