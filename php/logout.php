<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/4/30
 * Time: 21:04
 */
session_start();
session_destroy();
header("location:../login.php");