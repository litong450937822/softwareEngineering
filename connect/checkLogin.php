<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/25
 * Time: 20:48
 */
session_start();
if (!isset($_SESSION['id'])) {
    header("location:../login.php");
}