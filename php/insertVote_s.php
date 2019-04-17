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
$array = [];
$rs = mysqli_query($conn, "SELECT * FROM vote_s WHERE vtid=$vtid AND sid = $sid");
if (mysqli_num_rows($rs) >= 1) {
    $array['state']= 1;
    echo json_encode($array);
}

$sql = "INSERT INTO vote_s VALUE ($vtid,$sid,$result) ";

$conn->query($sql);
$array['state']= 0;
echo json_encode($array);