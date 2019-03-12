<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/5
 * Time: 22:12
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");

$qtid = $_POST['qtid'];
$sql = "DELETE FROM question_t WHERE qtid = $qtid";
if ($conn->query($sql) ===TRUE){
    return 'success';
}else{
    echo 'Error:'. $sql.'<br>'.$conn->error;
    return 'error';
}