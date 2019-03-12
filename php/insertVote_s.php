<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/10
 * Time: 17:37
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$vtid = $_SESSION['vtid'];
$sid = $_SESSION['id'];
$result = $_POST['result'];

$rs = mysqli_query($conn, "SELECT * FROM vote_s WHERE vtid=$vtid AND sid = $sid");
if (mysqli_num_rows($rs) >= 1) {
    return 'error';
}

$sql = "INSERT INTO vote_s VALUE ($vtid,$sid,$result) ";

if (mysqli_query($conn, $sql)) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
