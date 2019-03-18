<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/11
 * Time: 22:48
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$loginTime = $_SESSION['loginTime'];
$sid = $_SESSION['id'];
$nowTime = date('H:i:s');
$date = date('Y/m/d');
$time = strtotime($nowTime) - strtotime($loginTime);
if ($loginTime == '')
    return 'error';
if (!isset($_SESSION['tid'])) {
    $sql = "INSERT INTO time (date, time, type, startTime, endTime, sid) VALUES 
('" . $date . "','" . $time . "','L','" . $loginTime . "','" . $nowTime . "',$sid)";
    $conn->query($sql);
    $rs = mysqli_query($conn, "SELECT @@IDENTITY AS id");
    $row = mysqli_fetch_assoc($rs);
    $_SESSION['tid'] = $row['id'];
}else{
    $id = $_SESSION['tid'];
    $sql = "UPDATE time SET time = '" . $time . "',endTime = '" . $nowTime . "' WHERE id = $id";
    $conn->query($sql);
}