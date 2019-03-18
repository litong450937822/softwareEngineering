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
$number = 1;
$vtid = $_POST['vtid'];
$options = '';
while (isset($_POST['option' . $number])) {
    $option = $_POST['option' . $number];
    $options = $options . $option .';';
    $number++;
}
$options = substr($options, 0, strlen($options)-1);
if ($vtid == ''){
    $sql = "INSERT INTO vote_t (title, options ,startTime, endTime, cid) VALUES ('" . $title . "','".$options ."','" . $startTime . "','" . $endTime . "',$cid)";
    $result = $conn->query($sql);
}else{
    $sql = "UPDATE vote_t SET title = '" . $title . "',startTime = '" . $startTime . "',endTime = '" . $endTime . "',options = '".$options."'
    WHERE vtid = $vtid";
    $result = $conn->query($sql);
}

if ($number > 1) {
    echo  $number -1;
    return $number -1 ;
}
else
    return 'error';