<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/3
 * Time: 11:31
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$qtid = $_SESSION['qtid'];
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "SELECT * FROM question_q WHERE qtid = $qtid GROUP BY number");
$count = mysqli_num_rows($rs);
$answerStr = '';
$correct = 0;
$number = 1;
$nowTime = date('Y/m/d H:i:s');

while ($row = mysqli_fetch_assoc($rs)) {
    $answer = $_POST['answer' . $number];
    $number++;
    $answerStr = $answerStr . $answer . ';';
}
$answerStr = substr($answerStr, 0, strlen($answerStr) - 1);
$rs = mysqli_query($conn, "SELECT * FROM question_s WHERE qtid = $qtid AND sid = $sid");
if (mysqli_num_rows($rs) >= 1) {
    $sql = "UPDATE question_s SET result = '" . $answerStr . "',submitTime = '" . $nowTime . "'  WHERE qtid = $qtid AND sid = $sid";
    if ($conn->query($sql))
        return 'success';
    else {
        echo 'Error:' . $sql . '<br>' . $conn->error;
        return 'error';
    }
} else {
    $sql = "INSERT INTO question_s (qtid,sid, result, submitTime) VALUES ($qtid,$sid, '" . $answerStr . "','" . $nowTime . "')";
    if ($conn->query($sql))
        return 'success';
    else {
        echo 'Error:' . $sql . '<br>' . $conn->error;
        return 'error';
    }
}