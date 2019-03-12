<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/1
 * Time: 15:51
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$wtid = $_SESSION['wtid'];
$sid = $_SESSION['id'];
$content = $_POST['content'];
$file = @$_POST['file'];
$nowTime = date('Y/m/d H:i:s');
$endTime = date('H:i:s');
$workTime = $_SESSION['workTime'];
$date = date('Y/m/d');
$time = strtotime($endTime) - strtotime($workTime);
$rs1 = mysqli_query($conn, "select * from work_s where wtid = $wtid AND sid = $sid");
if (mysqli_num_rows($rs1) >= 1) {
    $sql = "UPDATE work_s SET answer = '$content', file = '$file', submitTime = '$nowTime' WHERE wtid = $wtid AND sid = $sid";
} else {
    $sql = "INSERT INTO work_s (wtid, sid, submitTime, answer, file) values ($wtid,$sid,'$nowTime','$content','$file') ";
}
if (mysqli_query($conn, $sql)) {
    echo "新记录插入成功";
    $sql = "INSERT INTO time (date, time, type, startTime, endTime, sid) VALUES ('" . $date . "',$time,'W','" . $workTime . "','" . $endTime . "',$sid)";
    $conn->query($sql);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
