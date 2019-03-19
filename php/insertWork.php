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
$wtid = $_POST['wtid'];
$file = @$_POST['file'];
$chid = $_POST['chid'];
if ($wtid == '')
    $sql = "INSERT INTO work_t (title, cid, content, startTime, endTime, file, chid) VALUE ('$title', $cid, '$content', '$startTime', '$endTime', '$file',$chid) ";
else
    $sql = "UPDATE work_t SET title = '" . $title . "',content = '" . $content . "',startTime = '" . $startTime . "',
    endTime = '" . $endTime . "',file = '" . $file . "',chid = $chid WHERE wtid = $wtid";
    if (mysqli_query($conn, $sql)) {
        return 'success';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return 'error';
    }
