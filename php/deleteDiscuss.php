<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/19
 * Time: 23:15
 */
require_once("../connect/conn.php");
$dsid = $_POST['dsid'];
$sql = "DELETE FROM discass_s WHERE dsid = $dsid";
if ($conn->query($sql) ===TRUE){
    echo '删除成功';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
}