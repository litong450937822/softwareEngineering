<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 20:32
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$time = $_POST['time'];
$_SESSION['time'] = $time;
echo $time;
return 'success';