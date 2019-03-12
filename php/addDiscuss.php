<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 17:50
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$title = $_POST['title'];
$cid = $_SESSION['cid'];
$nowTime = date('Y/m/d H:i:s');
$sql = "INSERT INTO discass_t(title,cid,lastUpdateTime,startTime) VALUES ('" . $title . "',$cid,'" . $nowTime . "','" . $nowTime . "')";
if ($conn->query($sql) === TRUE) {
    echo '添加成功';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
}