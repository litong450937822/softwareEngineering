<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/1
 * Time: 15:51
 */

require_once("../connect/conn.php");
session_start();
$wtid = $_SESSION['wtid'];
$sid = $_SESSION['id'];
$content = $_POST['content'];
$file = $_POST['file'];
$nowTime = date('Y/m/d h:i');

$rs1 = mysqli_query($conn, "select * from work_s where wtid = $wtid AND sid = $sid");
if (mysqli_num_rows($rs1) >= 1) {
    $sql = "UPDATE work_s SET content = '$content', file = '$file', submitTime = '$nowTime' WHERE wtid = $wtid AND sid = $sid";
}else{
    $sql = "INSERT INTO work_s (wtid, sid, submitTime, content, file) values ($wtid,$sid,'$nowTime','$content','$file') ";
}
if (mysqli_query($conn, $sql)) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
