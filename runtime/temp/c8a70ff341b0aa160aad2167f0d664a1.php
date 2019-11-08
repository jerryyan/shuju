<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\WWW\shuju\public/../application/index\view\sousuo\index.html";i:1567047276;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文件管理</title>
    <link rel="stylesheet" href="/static/assert/layui/css/layui.css">
    <link rel="stylesheet" href="/static/assert/bootstrap/css/bootstrap.css">
    <style>
        a {
            text-decoration: none !important;
        }
    </style>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">文件管理</div>
        </div>
        <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree" lay-filter="test">
            <li class="layui-nav-item ">
                <a class="" href="/search/show">词根管理</a>
            </li>
            <li class="layui-nav-item ">
                <dd><a href="/jinjia/addUser">项目账号管理</a></dd>
            </li>
            <li class="layui-nav-item  layui-nav-itemed">
                <a class="" href="javascript:;">文件上传</a>
                <dl class="layui-nav-child">
                    <dd><a style="color:#ffffff" href="/">商务通历史导入</a></dd>
                    <dd><a href="/jinjia/index">竞价助手报告导入</a></dd>
                    <dd><a href="/sousuo">搜索词报告导入</a></dd>                    
                </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;">文件管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="/index/swtFile">商务通历史数据</a></dd>
                    <dd><a href="/jinjia/jjFile">竞价助手报告数据</a></dd>
                    <dd><a href="/sousuo/show">搜索词报告数据</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item ">
                <dd><a href="/sousuo/set">数据处理</a></dd>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;">数据展现</a>
                <dl class="layui-nav-child"> 
                    <dd><a href="/search">搜索词数据</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;">临时数据处理</a>
                <dl class="layui-nav-child">
                    <dd><a style="color:#ffffff" href="/lswt/index">商务通文件上传</a></dd>
                    <dd><a href="/lswt/swtFile">商务通文件管理</a></dd>
                    <dd><a href="/ljinjia/index">竞价文件上传</a></dd>
                    <dd><a href="/ljinjia/jjFile">竞价文件管理</a></dd>
                    <dd><a href="/lsousuo">搜索词导入</a></dd>
                    <dd><a href="/lsearch">搜索词数据</a></dd>                  
                </dl>
            </li>
        </ul>
    </div>
</div>

        <div class="layui-body" style="padding: 15px;">
            <!-- 内容主体区域 -->
            <div class="layui-row layui-col-space18">
                <div class="layui-col-md2">
                    <!-- <input type="text" name="title" placeholder="请输入项目名" class="layui-input xiangmu"> -->
                    <select class="form-control xiangmu">
                        <option selected>请选择项目</option>
                        <option value="远大肛肠">远大肛肠</option>
                        <option value="远大胃肠">远大胃肠</option>
                    </select>
                </div>
                <div class="layui-col-md2">
                    <select class="form-control qudao">
                        <option selected>请选择渠道</option>
                        <option value="百度">百度</option>
                        <option value="搜狗">搜狗</option>
                        <option value="神马">神马</option>
                        <option value="360">360</option>
                    </select>
                </div>
                <div class="layui-col-md10">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn layui-btn-normal" id="test8">选择文件</button>
                        <button type="button" class="layui-btn" id="test9">提交</button>
                    </div>
                </div>
            </div>
            <!-- <table class="layui-table">
                <thead>
                    <tr>
                        <th>序号</th>
                        <td>项目</td>
                        <th>渠道</th>
                        <th>文件名</th>
                        <th>添加时间</th>
                        <th>编辑</th>
                    </tr>
                </thead>
                <tbody class="tb">
                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['xiangmu']; ?></td>
                        <td><?php echo $vo['source']; ?></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['atime']; ?></td>
                        <td>
                            <button type="button" onclick="deleted(<?php echo $vo['id']; ?>)" class="layui-btn layui-btn-xs">删除</button>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table> -->
            <!-- <div class="layui-input-inline">
                <input type="text" class="layui-input" id="time1" placeholder="yyyy-MM-dd">
            </div>
            <button type="button" class="btn btn-success abc">处理已上传商务通和竞价数据</button> -->
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            深圳远大肛肠医院
        </div>

    </div>
</body>
<script src="/static/assert/layui/layui.js"></script>
<script>
    layui.use(['table', 'element', 'form', 'upload', 'laydate'], function () {
        var element = layui.element
        var table = layui.table
        var $ = layui.jquery
        var upload = layui.upload;
        var laydate = layui.laydate;

        laydate.render({
            elem: '#time1',
            value: new Date()
        });
        //选完文件后不自动上传
        upload.render({
            elem: '#test8',
            url: '/sousuo/swtImport',
            data: {
                xiangmu: function () {
                    return $('.xiangmu').val()
                },
                qudao: function () {
                    return $('.qudao').val()
                }
            },
            before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.load(); //上传loading
            },
            auto: false,
            accept: 'file',
            bindAction: '#test9',
            done: function (res) {
                layer.closeAll();
                layer.msg(res.msg);
            }
        });
        $('.abc').click(function () {
            layer.open({
                type: 3,
            });
            $.ajax({
                type: "post",
                url: "/sousuo/swtData",
                data: {
                    timer: $('#time1').val()
                },
                dataType: "json",
                success: function (res) {
                    layer.closeAll();
                    layer.msg(res.msg);

                }
            });
        })
    })

    // function deleted(ids) {
    //     var $ = layui.jquery;
    //     layer.open({
    //         type: 1,
    //         content: '<p style="text-align: center">确定删除吗?</p>',
    //         btn: ['确定', '取消'],
    //         yes: function (index, layero) {
    //             $.ajax({
    //                 type: "post",
    //                 dataType: "JSON",
    //                 url: "/sousuo/del",
    //                 data: {
    //                     id: ids
    //                 },
    //                 success: function (res) {
    //                     layer.closeAll();
    //                     layer.msg(`序号Id为${ids}的数据` + res.msg);
    //                     location.reload();
    //                 }
    //             });
    //         },
    //     });
    // }
</script>

</html>