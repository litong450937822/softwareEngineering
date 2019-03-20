<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/20
 * Time: 2:16
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$chid = $_POST['id'];
echo $chid;
$sql = "DELETE FROM chapter WHERE chid = $chid";
if ($conn->query($sql) === TRUE) {
    echo $sql;
    return 'success';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
    return 'error';
}