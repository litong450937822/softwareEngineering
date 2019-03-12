<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/12
 * Time: 23:04
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$number = $_GET['number'];
$rs = mysqli_query($conn, "SELECT * FROM student LEFT JOIN class c on student.clid = c.clid WHERE number = $number");
$cid = $_SESSION['cid'];
$row = mysqli_fetch_assoc($rs);
$sid = $row['sid'];
function get_weeks($time = '', $format = 'Y/m/d')
{
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i = 1; $i <= 7; $i++) {
        $date[$i] = date($format, strtotime('+' . $i - 7 . ' days', $time));
    }
    return $date;
}

$dates = get_weeks();

function getTime($date)
{
    global $conn, $sid;
    $sql = "SELECT * FROM time WHERE sid = $sid AND type = 'L' AND date = '" . $date . "'";
    $rs = mysqli_query($conn, $sql);
    $times = mysqli_num_rows($rs);
    return $times;
}
$time1 = getTime($dates[1]);
$time2 = getTime($dates[2]);
$time3 = getTime($dates[3]);
$time4 = getTime($dates[4]);
$time5 = getTime($dates[5]);
$time6 = getTime($dates[6]);
$time7 = getTime($dates[7]);

?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('e')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/browseStudent.php')">查看学生</a>
            <a><cite><?php echo $row['name']; ?></cite></a>
        </span>
    </div>
    <div class="content">
        <img src="img/<?php echo $row['profilePhoto']; ?>" class="layui-img" width="80px" style="border-radius: 50%">
        <span style="font-size: 20px"><?php echo $row['name']; ?></span>
        <p style="font-size: 20px;margin-top: 20px">班级：<?php echo $row['className']; ?></p>
        <div id="main" style="width: 800px;height:600px;margin-top: 20px"></div>
    </div>

</div>

<script>
    layui.use('element', function () {
        let element = layui.element;

        element.render();

    });

    myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    option = {
        title: {
            text: '近七日登陆情况'
        },
        color: ['#3398DB'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                data: ['<?php echo $dates[1] ?>', '<?php echo $dates[2] ?>', '<?php echo $dates[3] ?>',
                    '<?php echo $dates[4] ?>', '<?php echo $dates[5] ?>', '<?php echo $dates[6] ?>',
                    '<?php echo $dates[7] ?>'],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        series: [
            {
                name: '登陆次数',
                type: 'bar',
                barWidth: '60%',
                data: [ <?php echo $time1 ?>, <?php echo $time2 ?>,
                    <?php echo $time3 ?>, <?php echo $time4 ?>,
                    <?php echo $time5 ?>, <?php echo $time6 ?>,
                    <?php echo $time7 ?>]
            }
        ]
    };

    myChart.setOption(option);
</script>