<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/25
 * Time: 20:53
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$wtid = is_null(@$_POST['id']) ? $_POST['wtid'] : $_POST['id'];
$sql = "DELETE FROM work_t WHERE wtid = $wtid";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}