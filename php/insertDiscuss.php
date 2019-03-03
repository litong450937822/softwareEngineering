<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/18
 * Time: 14:39
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$id = $_POST['id'];
$dtid = $_POST['dtid'];
$content = $_POST['content'];
$identity = $_POST['identity'];
$nowTime = date('Y/m/d h:i:s');
$sql =  "INSERT INTO discass_s(dtid, id, time, content, identity) VALUES ($dtid,$id,'".$nowTime."','".$content."','".$identity."')";
if ($conn->query($sql) === TRUE) {
    echo '回复成功';
    $sql = "UPDATE discass_t SET lastUpdateTime = '".$nowTime."' WHERE dtid = $dtid";
    $result = $conn->query($sql);
    echo $result;
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
}
