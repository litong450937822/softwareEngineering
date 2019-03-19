<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/20
 * Time: 1:06
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$copyId = $_POST['copyId'];
$copyNumber = $_POST['copyNumber'];
$number = $_POST['number'];
$row = mysqli_fetch_assoc($conn->query("SELECT chid FROM chapter WHERE number = $copyNumber AND cid = $copyId"));
$copyChid = $row['chid'];
$cid = $_SESSION['cid'];
$sql = "INSERT INTO chapter(cid, number, title, type, content, time)
(SELECT replace(cid,$copyId,$cid) AS cid,replace(number,$copyNumber,$number) AS number,title,type,content,time FROM chapter WHERE cid = $copyId AND number = $copyNumber)";
if(!$conn->query($sql))
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
$row = mysqli_fetch_assoc($conn->query("SELECT chid FROM chapter WHERE cid = $cid AND type = 'T' AND number = $number"));
$chid = $row['chid'];
$sql = "INSERT INTO work_t (title, cid, content, startTime, endTime, file, chid) 
(SELECT title, replace(cid,$copyId,$cid) AS cid,content,startTime,endTime,file,replace(chid,$copyChid,$chid) AS chid FROM work_t WHERE chid = $copyChid)";
if(!$conn->query($sql))
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
$sql = "INSERT INTO discass_t(title, cid, startTime, chid) 
(SELECT title,replace(cid,$copyId,$cid) AS cid,startTime,replace(chid,$copyChid,$chid) AS chid FROM discass_t WHERE chid = $copyChid)";
if(!$conn->query($sql))
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);