<?php
/**
 * Created by PhpStorm.
 * User: TemperanceXIV
 * Date: 2019/2/25
 * Time: 21:23
 */

require_once("../connect/conn.php");
require_once("../connect/checkLogin.php");
$wtid = @$_GET['wtid'];
$number = @$_GET['number'];
$cid = $_SESSION['cid'];
if ($wtid != null) {
    $rs = mysqli_query($conn, "SELECT * FROM work_t WHERE wtid = $wtid");
    $row = mysqli_fetch_assoc($rs);
}
$rs1 = mysqli_query($conn, "SELECT * FROM chapter WHERE cid = $cid AND type = 'T'");
?>
<div class="layui-col-md8 layui-col-md-offset2" style="padding-top: 30px;" id="layer">
    <div style="margin-bottom: 15px">
        <span class="layui-breadcrumb" style="margin-bottom: 20px">
            <a class="link" onclick="backToSelect('t')">课程选择</a>
            <?php
            if ($number != null)
                echo '<a class="link" onclick="gotoPage(\'teacher/courseChapter.php\')">课程章节</a>';
            else
                echo '<a class="link" onclick="gotoPage(\'teacher/sWork.php\')">作业</a>';
            ?>
            <a><cite><?php
                    if ($wtid != null)
                        echo '编辑作业';
                    else
                        echo '添加作业';
                    ?></cite></a>
        </span>
    </div>
    <?php if (mysqli_num_rows($rs1) >= 1) { ?>
        <form class="layui-form layui-form-pane" action="" lay-filter="work">
            <div class="layui-form-item">
                <label class="layui-form-label">作业标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" autocomplete="off" placeholder="请输入标题" lay-verify="title"
                           class="layui-input" value="<?php echo @$row['title'] ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">起始时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="startTime" id="startTime" autocomplete="off" lay-verify="required"
                               value="<?php if ($wtid != null)
                                   echo $row['startTime'];
                               else
                                   echo date('Y/m/d h:i:s'); ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">结束时间</label>
                    <div class="layui-input-inline">
                        <input type="text" name="endTime" id="endTime" autocomplete="off" lay-verify="endTime"
                               class="layui-input" value="<?php echo @$row['endTime'] ?>">
                    </div>
                </div>
            </div>
            <div class="layui-form-block" style="margin-bottom: 20px">
                <label class="layui-form-label">选择章节</label>
                <div class="layui-input-block" style="width: 200px">
                    <select name="chid" data-number="<?php echo $number ?>" lay-filter="chapter">
                        <option value="">请选择章节</option>
                        <?php
                        while ($row1 = mysqli_fetch_assoc($rs1)) {
                            ?>
                            <option value="<?php echo $row1['chid'] ?>" <?php
                            if ($number == $row1['number'])
                                echo 'selected=""';
                            ?>><?php echo '第' . $row1['number'] . '章 ' . $row1['title'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">作业内容</label>
                <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="content" lay-verify="required"
                          class="layui-textarea"><?php echo @$row['content'] ?></textarea>
                </div>
            </div>
            <div class="layui-upload">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>文件名</th>
                            <th>大小</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="demoList">
                        <?php if ($wtid != null && $row['file'] != '') {
                            $files = explode(";", $row['file']);
                            for ($i = 0; $i < count($files); $i++) {
                                $url = '../file/' . $_SESSION['number'] . '/' . $files[$i];
                                $url = iconv("UTF-8", "gb2312", $url);
                                ?>
                                <tr id="upload-<?php echo $i; ?>">
                                    <td id="fileName"><?php echo $files[$i] ?></td>
                                    <td><?php if (file_exists($url)) {
                                            $fileSize = round(filesize($url) / 1024);
                                            echo $fileSize . 'KB';
                                        } else echo 0; ?></td>
                                    <td>已经上传</td>
                                    <td>
                                        <button class="layui-btn layui-btn-xs layui-btn-danger" type="button"
                                                onclick="delFile('upload-<?php echo $i; ?>','<?php echo $files[$i] ?>')">
                                            删除
                                        </button>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="layui-form-item">
                <button type="button" class="layui-btn" id="testList">选择文件</button>
                <button type="button" class="layui-btn" id="upload">上传文件</button>
            </div>
            <button class="layui-btn " lay-submit="" lay-filter="insertWork" id="submit">提交</button>
        </form>
        <?php
    }else {
    ?>
        <div style="width: 100%;height: 150px;background-color: #f5f5f5;
        text-align: center;line-height: 150px;border-radius: 4px">
            <p style="color: #999;font-size: 30px;font-weight: bolder">该课程暂无章节</p>
        </div>
        <?php
    }
    ?>
</div>

<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        let form = layui.form
            , layer = layui.layer
            , laydate = layui.laydate;

        form.render();
        //日期
        laydate.render({
            elem: '#startTime'
            , type: 'datetime'
            , format: 'yyyy/MM/dd HH:mm:ss'
        });

        laydate.render({
            elem: '#endTime'
            , type: 'datetime'
            , format: 'yyyy/MM/dd HH:mm:ss'
        });

        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '标题不得少于5个字符';
                }
            }
            , endTime: function (value) {
                if (value === '') {
                    return '必填项不能为空';
                }
                let startTime = $('#startTime').val();
                let endTime = $('#endTime').val();
                let start = new Date(startTime.replace("-", "/").replace("-", "/"));
                let end = new Date(endTime.replace("-", "/").replace("-", "/"));
                if (end < start) {
                    return '结束时间不能小于开始时间';
                }
            }
        });

        form.on('submit(insertWork)', function (data) {
            let fileStr = '';
            $('td#fileName').each(function () {
                fileStr += $(this).text() + ';';
            });
            fileStr = fileStr.substr(0, fileStr.length - 1);
            data.field.file = fileStr;
            data.field.wtid = '<?php echo $wtid ?>';
            $.ajax({
                url: './php/insertWork.php',
                type: 'post',
                data: data.field,
                success: function () {
                    gotoPage('teacher/sWork.php');
                }
            });
            return false; //阻止表单跳转
        });

    });

    layui.use('element', function () {
        let element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        element.render();
    });

    layui.use('upload', function () {
        let $ = layui.jquery
            , upload = layui.upload;
        let demoListView = $('#demoList')
            , uploadListIns = upload.render({
            elem: '#testList'
            , url: './php/upload.php'
            , accept: 'file'
            , data: {
                content: function () {
                    return $('#workContent').val();
                }
            }
            , multiple: true
            , auto: false
            , bindAction: '#upload'
            , choose: function (obj) {
                let files = obj.pushFile(); //将每次选择的文件追加到文件队列


                //读取本地文件
                obj.preview(function (index, file) {
                    let tr = $(['<tr id="upload-' + index + '">'
                        , '<td id="fileName">' + file.name + '</td>'
                        , '<td>' + (file.size / 1014).toFixed(1) + 'kb</td>'
                        , '<td>等待上传</td>'
                        , '<td>'
                        , '<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                        , '<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        , '</td>'
                        , '</tr>'].join(''));

                    //单个重传
                    tr.find('.demo-reload').on('click', function () {
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function () {
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选

                    });

                    demoListView.append(tr);
                });
            }
            , done: function (res, index) {
                if (res.code === 0) { //上传成功
                    let tr = demoListView.find('tr#upload-' + index)
                        , tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    // return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
            }
            , allDone: function (obj) { //当文件全部被提交后，才触发
                $('.layui-word-aux').append("执行完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");

                layer.msg("上传完毕，文件总数：" + obj.total + "成功：" + obj.successful + "个，失败：" + obj.aborted + "个");
            }
        });
    });

    function delFile(index, fileName) {
        $('#' + index).remove();

        $.ajax({
            url: './php/delFile.php',
            type: 'post',
            data: {fileName: fileName},
            success: function () {
                layer.msg('删除成功');
            },
            error: function () {
                layer.msg('删除失败');
            }
        });
    }
</script>