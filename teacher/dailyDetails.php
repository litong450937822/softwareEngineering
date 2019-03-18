<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/13
 * Time: 22:46
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$date = $_GET['date'];
$sid = $_GET['sid'];
$rs = mysqli_query($conn, "SELECT * FROM student WHERE sid = $sid");
$row = mysqli_fetch_assoc($rs);
$rs1 = mysqli_query($conn, "SELECT SUM(time) as titleTime FROM time 
WHERE sid = $sid AND type='L' AND date = '" . $date . "'");
$row1 = mysqli_fetch_assoc($rs1);
$title = gmstrftime('%H:%M:%S', $row1['titleTime']);
$rs1 = mysqli_query($conn, "SELECT count(*) as count FROM time WHERE sid = $sid AND type='O' AND date = '" . $date . "'");
$rs2 = mysqli_query($conn, "SELECT count(*) as count FROM time WHERE sid = $sid AND type='D' AND date = '" . $date . "'");
$rs3 = mysqli_query($conn, "SELECT count(*) as count FROM time WHERE sid = $sid AND type='V' AND date = '" . $date . "'");
$rs4 = mysqli_query($conn, "SELECT count(*) as count FROM time WHERE sid = $sid AND type='Q' AND date = '" . $date . "'");
$rs5 = mysqli_query($conn, "SELECT count(*) as count FROM time WHERE sid = $sid AND type='E' AND date = '" . $date . "'");
$row1 = mysqli_fetch_assoc($rs1);
$row2 = mysqli_fetch_assoc($rs2);
$row3 = mysqli_fetch_assoc($rs3);
$row4 = mysqli_fetch_assoc($rs4);
$row5 = mysqli_fetch_assoc($rs5);
$workTime = $row1['count'];
$voteTime = $row2['count'];
$discussTime = $row3['count'];
$questionTime = $row4['count'];
$testTime = $row5['count'];

?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('e')">课程选择</a>
            <a class="link" onclick="gotoPage('teacher/browseStudent.php')">查看学生</a>
            <a class="link"
               onclick="gotoPage('teacher/student.php?number=<?php echo $row['number'] ?>')"><?php echo $row['name']; ?></a>
            <a><cite><?php echo $date; ?> 详情</cite></a>
        </span>
    </div>
    <div class="content">
        <img src="img/<?php echo $row['profilePhoto']; ?>" class="layui-img" width="80px"
             style="border-radius: 50%">
        <span style="font-size: 20px"><?php echo $row['name']; ?></span>
        <p style="font-size: 20px;margin-top: 20px">今日登录时间：<?php echo $title; ?></p>
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
        title : {
            text: '访问情况',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            type: 'scroll',
            orient: 'vertical',
            right: 10,
            top: 20,
            bottom: 20,
            data: ['作业','讨论','投票','问卷','测验']

            // selected: data.selected
        },
        series: [
            {
                name: '访问来源',
                type: 'pie',
                radius: '55%',
                center: ['50%', '50%'],
                data: [
                    {value:<?php echo $workTime ?>, name: '作业'},
                    {value:<?php echo $discussTime ?>, name: '讨论'},
                    {value:<?php echo $voteTime ?>, name: '投票'},
                    {value:<?php echo $questionTime ?>, name: '问卷'},
                    {value:<?php echo $testTime ?>, name: '测试'}
                ]
            }
        ]
    };

    myChart.setOption(option);
</script>
