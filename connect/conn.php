<?PHP
	$conn = mysqli_connect("localhost:3306","root","root","software");
	if (!$conn) {
    	die("连接失败: " . mysqli_connect_error());
	}
	mysqli_query($conn,"SET NAMES utf8");
?>

