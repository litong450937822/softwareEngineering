<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 19:14
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$clid = $_SESSION['clid'];
$time = $_POST['rollCallTime'];
$oldTime = $_POST['oldTime'];
$rs = mysqli_query($conn, "SELECT * FROM student WHERE clid = $clid");
while ($row = mysqli_fetch_assoc($rs)) {
    $sid = $row['sid'];
    $state = $_POST[$sid];
    if ($oldTime =='') {
        $sql = "INSERT INTO rollcall(sid, time, state, cid) VALUES ($sid,'" . $time . "','" . $state . "',$cid)";
        $request = $conn->query($sql);
    }else{
        $sql = "UPDATE rollCall SET time = '".$time."',state = '".$state."' 
        WHERE sid = $sid AND time = '".$oldTime."' AND cid = $cid";
        $request = $conn->query($sql);
    }
    if (!$request)
        return 'error';
}
return 'success';
