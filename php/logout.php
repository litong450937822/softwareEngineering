<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/4/30
 * Time: 21:04
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
require_once("./loginTime.php");
session_destroy();

header("location:../login.php");