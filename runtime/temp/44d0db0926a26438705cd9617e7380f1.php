<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\WWW\shuju\public/../application/index\view\index\swt_file.html";i:1568791843;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文件管理</title>
    <link rel="stylesheet" href="/static/assert/layui/css/layui.css">
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">文件管理</div>
            <!-- <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-this"><a href="/static/index.html">首页</a></li>
                <li class="layui-nav-item"><a href="/static/index_2.html">文件管理</a></li>
                <li class="layui-nav-item"><a href="/static/index_3.html">添加账号</a></li>
            </ul> -->
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

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                <div class="layui-form">
                    <div class="layui-form-item">
                        <!-- <label class="layui-form-label">单行输入框</label> -->
                        <div class="layui-input-block" style="display: flex;margin-left: 0 !important;">
                            <input type="text" name="title" placeholder="请输入标题" class="layui-input suosoustr"
                                style="width: 300px;">
                            <button type="button" class="layui-btn strs">搜索</button>
                        </div>
                    </div>
                    <table class="layui-table" id="layui-table">
                        <colgroup>
                            <col width="200">
                            <col width="600">
                            <col width="380">
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>文件名</th>
                                <th>上传时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tbody class="addTab">
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['name']; ?></td>
                                <td><?php echo $vo['atime']; ?></td>
                                <td><button type="button" onclick="deleted('<?php echo $vo['uniqid']; ?>')"  class="layui-btn layui-btn-sm layui-btn-danger">删除</button></td>
                            </tr>
                        </tbody>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </table>
                    <div id="page"></div>
                </div>

            </div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            深圳远大肛肠医院
        </div>
    </div>
</body>
<script src="/static/assert/layui/layui.js"></script>
<script src="/static/assert/template-web.js"></script>
<script>
    layui.use(['upload', 'layer', 'laypage', 'form', 'element'], function () {
        var element = layui.element;
        var form = layui.form;
        var $ = layui.jquery;
        upload = layui.upload
        var laypage = layui.laypage

        
        var aaaa = undefined
        var idsp = 1
        lk()
        function lk() {
            // var str=decodeURI(location.href).split('?')[1].split('&')[1].split('=')[1];
            var str = decodeURI(location.href)
            if (str.indexOf('&') != -1) {
                aaaa = str.split('?')[1].split('&')[1].split('=')[1]
                $('.suosoustr').val(aaaa)
            }
        }
        
        $('.strs').click(function () {
            var str = $('.suosoustr').val()
            if (str == '') {
                location.href = `/index/swtFile?p=${idsp}`
                return
            }
            location.href = `/index/swtFile?p=${idsp}&str=${str}`
        })
        laypage.render({
            elem: 'page',
            limit: <?php echo $limit; ?>,
            curr: <?php echo $p; ?>,
            count: <?php echo $count; ?>,
            jump: function (obj, first) {
                if (!first) {
                    idsp=obj.curr
                    current = obj.curr
                    if (!$('.suosoustr').val()=='') {
                        location.href = `/jinjia/jjFile?p=${obj.curr}&str=${$('.suosoustr').val()}`
                        return
                    }
                    location.href = `/index/swtFile?p=${obj.curr}`
                }
            }
        });
    })

    function deleted(ids) {
        var $ = layui.jquery;
        var layer = layui.layer;
        $.ajax({
            type: "post",
            url: "/index/del",
            data: {
                id: ids
            },
            dataType: "json",
            success: function (res) {
                // console.log(response);
                if (res.code == 1) {
                    layer.msg(res.msg);
                    location.reload();
                }
            }
        });
    }
</script>

</html>