<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/19
 * Time: 23:15
 */
require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$dsid = $_POST['dsid'];
$sql = "DELETE FROM discass_s WHERE dsid = $dsid";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}