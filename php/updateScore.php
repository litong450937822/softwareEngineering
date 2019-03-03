<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 14:34
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$score = $_POST['score'];
$wtid = $_POST['wtid'];
$sid = $_POST['sid'];
$sql = "UPDATE work_s SET score = $score WHERE wtid = $wtid AND sid = $sid";
if ($conn->query($sql) === TRUE) {
    echo '得分修改成功';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
}