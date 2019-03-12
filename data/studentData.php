<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/1
 * Time: 23:28
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$rs = mysqli_query($conn, "SELECT clid FROM course WHERE cid = $cid");
$row = mysqli_fetch_assoc($rs);
$clid = $row['clid'];
$rs = mysqli_query($conn, "SELECT * FROM student WHERE clid = $clid ");
$count = mysqli_num_rows($rs);
$userArray = array();

class Student
{
    public $number;
    public $name;
    public $sex;
    public $loginNumber;
    public $lastLoginDate;
    public $testAvgScore;
    public $workAvgScore;
}

while ($row = mysqli_fetch_assoc($rs)) {
    $sid = $row['sid'];
    $rs1 = mysqli_query($conn, "SELECT * FROM time WHERE type = 'L' AND sid = $sid ORDER BY id DESC ");
    $loginNumber = mysqli_num_rows($rs1);
    $row1 = mysqli_fetch_assoc($rs1);
    $lastLoginDate = $row1['date'];
    $rs1 = mysqli_query($conn,"SELECT avg(score) as testAvgScore FROM test_s WHERE sid = $sid");
    $row1 = mysqli_fetch_assoc($rs1);
    $testAvgScore = $row1['testAvgScore'];
    $rs1 = mysqli_query($conn,"SELECT avg(score) as workAvgScore FROM work_s WHERE sid = $sid");
    $row1 = mysqli_fetch_assoc($rs1);
    $workAvgScore = $row1['workAvgScore'];
    $student = new  Student();
    $student->number = $row['number'];
    $student->name = $row['name'];
    $student->sex = $row['sex'];
    $student->loginNumber = $loginNumber;
    $student->lastLoginDate = $lastLoginDate;
    $student->testAvgScore = $testAvgScore;
    $student->workAvgScore = $workAvgScore;
    $studentArray[] = $student;
}
$data = array(
    "code" => 0,
    "msg" => '',
    "count" => $count,
    "data" => $studentArray
);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
