<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/5
 * Time: 21:04
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$title = $_POST['title'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$cid = $_SESSION['cid'];
$qtid = $_POST['qtid'];
$number = 1;
if ($qtid == '') {
    $sql = "INSERT INTO question_t (title, startTime, endTime, cid) VALUES ('" . $title . "','" . $startTime . "','" . $endTime . "',$cid)";
    $result = $conn->query($sql);
    $sql = "SELECT @@IDENTITY AS qtid";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rs);
    $qtid = $row['qtid'];
    while (isset($_POST['question' . $number])) {
        $question = $_POST['question' . $number];
        $sql = "INSERT INTO question_q (number, qtid, question) 
VALUES ($number,'" . $qtid . "','" . $question . "' ) ";
        $result = $conn->query($sql);
        $number++;
    }
} else {
    $sql = "UPDATE question_t SET title = '" . $title . "',startTime = '" . $startTime . "',endTime = '" . $endTime . "' 
    WHERE qtid = $qtid";
    $result = $conn->query($sql);
    $sql = "DELETE  FROM question_s WHERE qtid=$qtid";
    $conn->query($sql);
    while (isset($_POST['question' . $number])) {
        $question = $_POST['question' . $number];
        $sql = "UPDATE question_q SET question = '" . $question . "' WHERE qtid = $qtid AND number = $number";
        $result = $conn->query($sql);
        $number++;
    }
}
if ($number > 1) {
    echo $number - 1;
    return $number - 1;
} else
    return 'error';