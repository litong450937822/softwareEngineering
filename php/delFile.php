<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/17
 * Time: 13:52
 */

require_once("../connect/checkLogin.php");
$fileName = $_POST['fileName'];
$number = $_SESSION['number'];
$url = '../file/' . $number . '/' . $fileName;
$url = iconv("UTF-8","gb2312", $url);
echo $url;
if (file_exists($url)) {
    if (unlink($url)) {
        echo '删除成功';
        return 'success';
    }else
        return 'error';
} else
    return 'error';