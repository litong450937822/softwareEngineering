<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/19
 * Time: 23:15
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$time = $_POST['time'];
$cid = $_SESSION['cid'];
$sql = "DELETE FROM rollcall WHERE cid = $cid AND time = '".$time."'";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}