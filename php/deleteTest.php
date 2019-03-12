<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/5
 * Time: 22:08
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$ttid = $_POST['ttid'];
$sql = "DELETE FROM test_t WHERE ttid = $ttid";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}