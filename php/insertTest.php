<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/3
 * Time: 1:06
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$title = $_POST['title'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$cid = $_SESSION['cid'];
$number = 1;
$ttid = $_POST['ttid'];
if ($ttid == '') {
    $sql = "INSERT INTO test_t (title, startTime, endTime, cid) VALUES ('" . $title . "','" . $startTime . "','" . $endTime . "',$cid)";
    $result = $conn->query($sql);
    $sql = "SELECT @@IDENTITY AS ttid";
    $rs = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rs);
    $ttid = $row['ttid'];
    while (isset($_POST['question' . $number])) {
        $question = $_POST['question' . $number];
        $option1 = $_POST['question' . $number . 'A'];
        $option2 = $_POST['question' . $number . 'B'];
        $option3 = $_POST['question' . $number . 'C'];
        $option4 = $_POST['question' . $number . 'D'];
        $answer = $_POST['answer' . $number];
        $sql = "INSERT INTO test_q (number, ttid, question, option1, option2, option3, option4, answer) 
VALUES ($number,'" . $ttid . "','" . $question . "','" . $option1 . "','" . $option2 . "'
,'" . $option3 . "','" . $option4 . "' ,'" . $answer . "')";
        $result = $conn->query($sql);
        $number++;
    }
}else {
    $sql = "UPDATE test_t SET title = '" . $title . "',startTime = '" . $startTime . "',endTime = '" . $endTime . "' 
    WHERE ttid = $ttid";
    $result = $conn->query($sql);
    while (isset($_POST['question' . $number])) {
        $question = $_POST['question' . $number];
        $option1 = $_POST['question' . $number . 'A'];
        $option2 = $_POST['question' . $number . 'B'];
        $option3 = $_POST['question' . $number . 'C'];
        $option4 = $_POST['question' . $number . 'D'];
        $answer = $_POST['answer' . $number];
        $sql = "UPDATE test_q SET question = '" . $question . "' ,option1 = '" . $option1 . "',option2 = '" . $option2 . "'
        ,option3 = '" . $option3 . "',option4 = '" . $option4 . "',answer = '".$answer."' WHERE ttid = $ttid AND number = $number";
        $result = $conn->query($sql);
        $number++;
    }
}
if ($number > 1) {
    echo $number - 1;
    return $number - 1;
}
else
    return 'error';