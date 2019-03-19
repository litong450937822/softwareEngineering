<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/20
 * Time: 2:16
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$number = $_POST['number'];
$cid = $_SESSION['cid'];
$sql = "DELETE FROM chapter WHERE number = $number AND cid = $cid";
if ($conn->query($sql) === TRUE) {
    echo $sql;
    return 'success';
} else {
    echo 'Error:' . $sql . '<br>' . $conn->error;
    return 'error';
}