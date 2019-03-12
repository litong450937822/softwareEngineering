<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/12
 * Time: 21:40
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
$_SESSION['cid'] = is_null(@$_GET['cid']) ? @$_SESSION['cid'] : @$_GET['cid'];
?>

<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('e')">课程选择</a>
            <a><cite>查看学生</cite></a>
        </span>
    </div>
    <table class="layui-hide layui-col-md-offset4" id="test" lay-filter="demo"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
    </script>
</div>
<script type="text/html" id="sexTpl">
    {{#  if(d.sex == 'W'){ }}
    <span style="color: #F581B1;">女</span>
    {{#  } else { }}
    <span style="color: ##1E9FFF;">男</span>
    {{#  } }}
</script>
<script>
    layui.use(['laydate', 'layer', 'table', 'element'], function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();

        let laydate = layui.laydate //日期
            , layer = layui.layer //弹层
            , table = layui.table; //表格


        //执行一个 table 实例
        table.render({
            elem: '#test'
            //,height: 760
            , url: 'data/studentData.php' //数据接口
            , width: 1200
            , text: {
                none: '该课程暂无学生'
            }
            , cols: [[ //表头
                {field: 'number', title: '学号', sort: true, unresize: true}
                ,{field: 'name', title: '姓名', sort: true, unresize: true}
                , {field: 'sex', title: '性别', sort: true, unresize: true, templet: '#sexTpl'}
                , {field: 'loginNumber', title: '登录次数', sort: true, unresize: true}
                , {field: 'lastLoginDate', title: '最后一次登陆日期', sort: true, unresize: true}
                , {field: 'testAvgScore', title: '测验平均分', sort: true, unresize: true, templet: '#testlevel'}
                , {field: 'workAvgScore', title: '作业平均分', sort: true, unresize: true, templet: '#testlevel'}
                , {fixed: 'right', title: '操作', align: 'center', toolbar: '#barDemo', unresize: true}
            ]]
            , id: 'userTable'
        });

        //监听工具条
        table.on('tool(demo)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            let data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'detail') {
                gotoPage('teacher/student.php?number=' + data.number);
            }
        });
    });
</script>
