<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 21:09
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>课程章节</cite></a>
        </span>
    </div>
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });
</script
