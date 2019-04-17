<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/3/18
 * Time: 21:09
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$cid = $_SESSION['cid'];
$tid = $_SESSION['id'];
$rs = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type = 'T'");
$count = mysqli_num_rows($rs);
$copy = @$_GET['copy'];
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <a><cite>课程章节</cite></a>
        </span>
    </div>
    <?php
    if ($count > 0) { ?>
        <div class="layui-collapse" lay-filter="test">
            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
                $number = $row['number'];
                $chid = $row['chid'];
                $rs1 = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type != 'T' AND number = $number")
                ?>
                <div class="layui-colla-item">
                    <h3 class="layui-colla-title">第<?php echo $number ?>章 <?php echo $row['title'] ?></h3>
                    <div class="layui-colla-content layui-show">
                        <table class="layui-table" lay-even="" lay-skin="nob">
                            <colgroup>
                                <col width="400">
                                <col width="100">
                            </colgroup>
                            <tbody>
                            <?php while ($row1 = mysqli_fetch_assoc($rs1)) { ?>
                                <tr>
                                    <td>
                                        <h2 class="link" id="item" style="margin-bottom: 5px"
                                            onclick="gotoPage('teacher/chapterItem.php?chid=<?php echo $row1['chid'] ?>')">
                                            <img src="icon/<?php
                                            switch ($row1['type']) {
                                                case 'A':
                                                    echo 'attachment.png';
                                                    break;
                                                case 'K':
                                                    echo 'link.png';
                                                    break;
                                            }
                                            ?>" class="layui-nav-img"><?php echo $row1['title'] ?>
                                        </h2>
                                    </td>
                                    <td>
                                        <button class="layui-btn layui-btn-sm delItem" data-method="delItem"
                                                data-title="<?php echo $row1['title'] ?>"
                                                data-type="I"
                                                data-id="<?php echo $row1['chid'] ?>">
                                            <i class="layui-icon">&#xe640;</i></button>
                                    </td>
                                </tr>

                            <?php }
                            $rs1 = mysqli_query($conn, "SELECT * FROM work_t WHERE cid = cid AND chid = $chid");
                            while ($row1 = mysqli_fetch_assoc($rs1)) {
                                ?>
                                <tr>
                                    <td>
                                        <h2 class="link" style="margin-bottom: 5px"
                                            onclick="gotoPage('teacher/workCompletion.php?wtid=<?php echo $row1['wtid'] ?>')">
                                            <img src="icon/work.png" class="layui-nav-img"><?php echo $row1['title'] ?>
                                        </h2>
                                    </td>
                                    <td>
                                        <button class="layui-btn layui-btn-sm delItem" data-method="delItem"
                                                data-title="<?php echo $row1['title'] ?>"
                                                data-type="W"
                                                data-id="<?php echo $row1['wtid'] ?>">
                                            <i class="layui-icon">&#xe640;</i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                            $rs1 = mysqli_query($conn, "SELECT * FROM discass_t WHERE cid = cid AND chid = $chid");
                            while ($row1 = mysqli_fetch_assoc($rs1)) {
                                ?>
                                <tr>
                                    <td>
                                        <h2 class="link" style="margin-bottom: 5px"
                                            onclick="gotoPage('teacher/discuss.php?dtid=<?php echo $row1['dtid'] ?>')">
                                            <img src="icon/disscuss.png"
                                                 class="layui-nav-img"><?php echo $row1['title'] ?>
                                        </h2>
                                    </td>
                                    <td>
                                        <button class="layui-btn layui-btn-sm delItem" data-method="delItem"
                                                data-title="<?php echo $row1['title'] ?>"
                                                data-type="D"
                                                data-id="<?php echo $row1['dtid'] ?>">
                                            <i class="layui-icon">&#xe640;</i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <form class="layui-form" action="">
                            <div class="layui-form-item">
                                <label class="layui-form-label">添加项目</label>
                                <div class="layui-input-block" style="width: 150px">
                                    <select name="item" data-number="<?php echo $number ?>" lay-filter="item">
                                        <option value="">请选择添加项目</option>
                                        <option value="A">附件</option>
                                        <option value="K">链接</option>
                                        <option value="W">作业</option>
                                        <option value="D">讨论</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <button class="layui-btn layui-btn-fluid layui-btn-primary delChapter" type="button"
                                data-title="<?php echo '第' . $row['number'] . '章 ' . $row['title'] ?>"
                                data-number="<?php echo $number ?>" style='margin-bottom: 10px'
                                data-method="confirmTrans">
                            <i class="layui-icon">&#x1007;</i>删除章节
                        </button>
                    </div>
                </div>
                <?php
            } ?>
        </div>
        <?php
    } else {
        ?>
        <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无章节</p>
        </div>
        <?php
    }
    ?>
    <form class="layui-form" action="" style="margin: 20px">
        <div class="layui-form-item">
            <label class="layui-form-label">复制章节</label>
            <div class="layui-input-inline">
                <select name="course" lay-filter="course">
                    <option value="">请选择复制课程</option>
                    <?php $rs2 = mysqli_query($conn, "SELECT * FROM course LEFT JOIN class c2 ON course.clid = c2.clid WHERE tid = $tid AND cid != $cid");
                    while ($row2 = mysqli_fetch_assoc($rs2)) { ?>
                        <option value="<?php echo $row2['cid'] ?>"
                            <?php if ($copy == $row2['cid']) echo 'selected=""' ?>><?php echo $row2['courseName'] . '-' . $row2['className'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="chapter" lay-filter="chapter">
                    <option value="">请选择章节</option>
                    <?php if ($copy != null) {
                        $rs2 = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $copy AND type='T'");
                        while ($row2 = mysqli_fetch_assoc($rs2)) { ?>
                            <option value="<?php echo $row2['number'] ?>"
                                    data-chid="<?php echo $row2['chid'] ?>"><?php echo '第' . $row2['number'] . '章 ' . $row2['title'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>
    <div style="width: auto; margin-top:20px ;" align="center">
        <button class="layui-btn layui-btn-fluid layui-btn-primary" type="button" data-method="offset"
                id="addChapter"><i class="layui-icon">&#xe608;</i>添加章节
        </button>
    </div>
</div>

<script>
    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    layui.use(['layer', 'form'], function () {
        let $ = layui.jquery, layer = layui.layer;
        let form = layui.form;
        let count = <?php echo $count + 1; ?>;
        let copyId = <?php echo is_null($copy) ? 0 : $copy  ?>;
        form.render();

        form.on('select(item)', function (data) {
            let number = data.elem.getAttribute("data-number");
            let type = data.value;
            switch (type) {
                case 'A':
                    gotoPage('teacher/inputAttachment.php?number=' + number);
                    break;
                case 'K':
                    gotoPage('teacher/inputLink.php?number=' + number);
                    break;
                case 'W':
                    gotoPage('teacher/inputWork.php?number=' + number);
                    break;
                case 'D':
                    gotoPage('teacher/inputDiscuss.php?number=' + number);
                    break;
            }
        });

        form.on('select(course)', function (data) {
            gotoPage('teacher/courseChapter.php?copy=' + data.value);
        });

        form.on('select(chapter)', function (data) {

            $.ajax({
                url: './php/copyChapter.php',
                type: 'post',
                data: {
                    copyId: copyId,
                    copyNumber: data.value,
                    number: count
                },
                success: function () {
                    gotoPage('teacher/courseChapter.php');
                    layer.msg('复制成功');
                }
            });
        });

        let active = {
            offset: function (othis) {
                layer.open({
                    type: 1
                    , title: '添加章节'
                    , offset: 'auto'
                    , id: 'chapter' //防止重复弹出
                    , content: '<div style="margin: 20px">' +
                    '<form class="layui-form layui-form-pane" action="" >\n' +
                    '<div class="layui-form-item">\n' +
                    '<label class="layui-form-label">章节名</label>\n' +
                    '<div class="layui-input-block">\n' +
                    '<input type="text" name="title" autocomplete="off" placeholder="请输入章节名" lay-verify="required" class="layui-input">\n' +
                    '</div>' +
                    '</div>' +
                    '</form>' +
                    '</div>'
                    , btnAlign: 'c' //按钮居中
                    , shade: 0.3
                    , btn: '确定'
                    , shadeClose: true
                    , yes: function (index) {
                        let title = $('input[name="title"]').val();
                        $.ajax({
                            url: './php/insertChapter.php',
                            type: 'post',
                            data: {
                                number: count,
                                title: title,
                            },
                            success: function () {
                                layer.close(index);
                                gotoPage('teacher/courseChapter.php');

                            }
                        });

                    }
                });
            },
            confirmTrans: function (othis) {
                let title = othis.data('title');
                let number = othis.data('number');
                //配置一个透明的询问框
                layer.msg('确认删除' + title + '吗？', {
                    time: 20000, //20s后自动关闭
                    btn: ['确认', '退出']
                    , btn1: function () {
                        $.ajax({
                            url: './php/deleteChapter.php',
                            type: 'post',
                            data: {
                                number: number
                            },
                            success: function () {
                                gotoPage('teacher/courseChapter.php');
                                layer.msg('删除成功');
                            }
                        });
                        layer.closeAll();
                    }
                })
            },
            delItem: function (othis) {
                let title = othis.data('title');
                let id = othis.data('id');
                let type = othis.data('type');
                let url = '';
                switch (type){
                    case 'W':
                        url = './php/deleteWork.php';
                        break;
                    case 'D':
                        url = './php/deleteDiscuss_t.php';
                        break;
                    case 'I':
                        url = './php/deleteItem.php';
                        break;
                }
                //配置一个透明的询问框
                layer.msg('确认删除' + title + '吗？', {
                    time: 20000, //20s后自动关闭
                    btn: ['确认', '退出']
                    , btn1: function () {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                id: id
                            },
                            success: function () {
                                gotoPage('teacher/courseChapter.php');
                                layer.msg('删除成功');
                            }
                        });
                        layer.closeAll();
                    }
                })
            }
        };
        $('#addChapter').on('click', function () {
            let othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        });

        $('.delChapter').on('click', function () {
            let othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        });
        $('.delItem').on('click', function () {
            let othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        });

    });


</script
