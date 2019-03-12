<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/1
 * Time: 18:09
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$dtid = $_POST['dtid'];
$sql = "DELETE FROM discass_t WHERE dtid = $dtid";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}