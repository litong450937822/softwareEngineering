<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2018/12/1
 * Time: 14:56
 */

session_start();
$schoolNumber = $_SESSION['schoolNumber'];


//上传文件目录获取
define('BASE_PATH', str_replace('\\', '/', realpath(dirname(__FILE__) . '/')) . "/");
$dir = BASE_PATH . "../file/" . $schoolNumber . "/";

//初始化返回数组
$arr = array(
    'code' => 0,
    'msg' => '',
    'data' => array(
        'src' => $dir . $_FILES["file"]["name"]
    ),
);
$filaName = iconv("UTF-8","gb2312", $_FILES["file"]["name"]);
$file_info = $_FILES['file'];
$file_error = $file_info['error'];
if (!is_dir($dir))//判断目录是否存在
{
    mkdir($dir, 0777, true);//如果目录不存在则创建目录
};
$file = $dir . $_FILES["file"]["name"];
if ($file_error == 0) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $filaName)) {
        $arr['msg'] = "上传成功";
    } else {
        $arr['msg'] = "上传失败";
    }
} else {
    switch ($file_error) {
        case 1:
            $arr['msg'] = '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
            break;
        case 2:
            $arr['msg'] = '超过了表单max_file_size限制的大小';
            break;
        case 3:
            $arr['msg'] = '文件部分被上传';
            break;
        case 4:
            $arr['msg'] = '没有选择上传文件';
            break;
        case 6:
            $arr['msg'] = '没有找到临时文件';
            break;
        case 7:
        case 8:
            $arr['msg'] = '系统错误';
            break;
    }
}

echo json_encode($arr);


