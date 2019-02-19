<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/18
 * Time: 14:39
 */
require_once("../connect/conn.php");
$id = $_POST['id'];
$dtid = $_POST['dtid'];
$content = $_POST['content'];
$nowTime = date('Y/m/d h:i:s');
$sql =  "INSERT INTO discass_s(dtid, sid, time, content) VALUES ($dtid,$id,'".$nowTime."','".$content."')";
if ($conn->query($sql) === TRUE) {
    echo '回复成功';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
}
