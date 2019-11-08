<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"D:\WWW\shuju\public/../application/index\view\jinjia\add_user.html";i:1564736463;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文件管理</title>
    <link rel="stylesheet" href="/static/assert/layui/css/layui.css">
    <style>
        .layui-form-label {
            width: 100px;
        }

        .layui-input-block {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <!-- <fieldset class="layui-elem-field layui-field-title"
        style="margin-top: 20px;margin-left: -1160px;text-align: center;">
        <legend>肛肠账号</legend>
    </fieldset> -->
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
                    <div style="width: 1238px;margin:10px auto;">
                        <button type="button" class="layui-btn layui-btn-normal" id="test8">选择文件</button>
                        <button type="button" class="layui-btn" id="test9">开始导入</button>
                    </div>
                    <table class="layui-table" style="width: 1238px;margin:30px auto;">
                        <colgroup>
                            <col width="128">
                            <col width="260">
                            <col width="250">
                            <col width="300">
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>账户标记</th>
                                <th>账户名</th>
                                <th>项目名</th>
                                <th>删除账号</th>
                            </tr>
                        </thead>
                        <tbody class="addTab1">
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['zhbj']; ?></td>
                                <td><?php echo $vo['name']; ?></td>
                                <td><?php echo $vo['xiangmu']; ?></td>
                                <td><button type="button" onclick="deleted(<?php echo $vo['id']; ?>)"
                                        class="layui-btn layui-btn-sm layui-btn-danger">删除</button></td>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                    <div style="display: flex;width: 1200px;margin-left: 168px;">
                        <label class="layui-form-label">账号标记</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" required lay-verify="required" placeholder="请输入账号标记"
                                autocomplete="off" class="layui-input biaoji">
                        </div>
                        <label class="layui-form-label">账号</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" required lay-verify="required" placeholder="请输入账号"
                                autocomplete="off" class="layui-input zhanghao">
                        </div>
                        <label class="layui-form-label">项目名</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" required lay-verify="required" placeholder="请输入项目名"
                                autocomplete="off" class="layui-input xiangmu">
                        </div>
                        <button type="button" style="margin-left: 100px;" id="sub" class="layui-btn">提交</button>
                    </div>
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
<script>
    layui.use(['upload', 'element', 'layer'], function () {
        var element = layui.element;
        var $ = layui.jquery;
        upload = layui.upload;
        var layer = layui.layer;

        //选完文件后不自动上传
        upload.render({
            elem: '#test8',
            url: '/jinjia/userImport',
            accept: 'file',
            exts: 'xls|excel|xlsx|cvs', //只允许上传压缩文件
            auto: false,
            bindAction: '#test9',
            done: function (res) {
                layer.msg(res.msg);
                location.reload();
            }
        });


        $('#sub').click(function () {
            $.ajax({
                type: "post",
                url: "/jinjia/addUser",
                data: {
                    zhbj: $('.biaoji').val(),
                    name: $('.zhanghao').val(),
                    xiangmu: $('.xiangmu').val()
                },
                dataType: "json",
                success: function (res) {
                    layer.msg(res.msg);
                    location.reload();
                }
            });
        })
    })

    function deleted(ids) {        
        var $ = layui.jquery;
        var layer = layui.layer;
        $.ajax({
            type: "post",
            url: "/jinjia/useDel",
            data: {id:ids},
            dataType: "json",
            success: function (res) {
                // console.log(response);
                if(res.code==1){
                    layer.msg(res.msg);
                    location.reload();
                }
            }
        });
    }
</script>

</html>