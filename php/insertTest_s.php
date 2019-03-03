<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/3
 * Time: 11:31
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$ttid = $_SESSION['ttid'];
$sid = $_SESSION['id'];
$rs = mysqli_query($conn, "SELECT * FROM test_q WHERE ttid = $ttid GROUP BY number");
$count = mysqli_num_rows($rs);
$answerStr = '';
$correct = 0;
$number = 1;
while ($row = mysqli_fetch_assoc($rs)) {
    $answer = $_POST['answer' . $number];
    if ($answer == $row['answer'])
        $correct++;
    $number++;
    $answerStr = $answerStr . $answer . ';';
}
$answerStr = substr($answerStr, 0, strlen($answerStr)-1);
$score = round(($correct / $count)*100);
echo $count."<br />";
echo $correct."<br />";
echo $score;
$rs = mysqli_query($conn, "SELECT * FROM test_s WHERE ttid = $ttid AND sid = $sid");
if (mysqli_num_rows($rs) >= 1) {
$sql = "UPDATE test_s SET answer = '".$answerStr."', score = $score  WHERE ttid = $ttid AND sid = $sid";
    if ($conn->query($sql))
        return 'success';
    else
        return 'error';
}else {
    $sql = "INSERT INTO test_s (ttid, answer, sid, score) VALUES ($ttid,'" . $answerStr . "',$sid,$score)";
    if ($conn->query($sql))
        return 'success';
    else
        return 'error';
}