<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\WWW\shuju\public/../application/index\view\index\index.html";i:1566353335;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
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
                <div class="layui-upload">
                    <button style="margin-left: 30px;" type="button" class="layui-btn layui-btn-normal"
                        id="testList">选择多文件</button>
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
                            <tbody id="demoList"></tbody>
                        </table>
                    </div>
                    <button style="margin-left: 30px;" type="button" class="layui-btn" id="testListAction">开始上传</button>
                </div>
            </div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            <div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="demo">
                <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
            </div>
            深圳远大肛肠医院
        </div>
    </div>
</body>
<script src="/static/assert/layui/layui.js"></script>
<script>
    console.log(window.navigator.platform);
    layui.use(['upload', 'element'], function () {
        var element = layui.element;
        var $ = layui.jquery;
        upload = layui.upload;

        var demoListView = $('#demoList'),
            uploadListIns = upload.render({
                elem: '#testList',
                url: '/index/swtImport',
                accept: 'file',
                exts: 'xls|excel|xlsx|cvs', //只允许上传压缩文件
                multiple: true,
                auto: false,
                bindAction: '#testListAction',
                choose: function (obj) {
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function (index, file, result) {
                        var tr = $(['<tr id="upload-' + index + '">', '<td>' + file.name +
                            '</td>', '<td>' +
                            (file.size / 1014).toFixed(1) + 'kb</td>', '<td>等待上传</td>',
                            '<td>',
                            '<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>',
                            '<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>',
                            '</td>', '</tr>'
                        ].join(''));

                        //单个重传
                        tr.find('.demo-reload').on('click', function () {
                            obj.upload(index, file);
                        });

                        //删除
                        tr.find('.demo-delete').on('click', function () {
                            delete files[index]; //删除对应的文件
                            tr.remove();
                            uploadListIns.config.elem.next()[0].value =
                                ''; //清空 input file 值，以免删除后出现同名文件不可选
                        });

                        demoListView.append(tr);
                    });
                },
                done: function (res, index, upload) {                    
                    if (res.code == 1) { //上传成功
                        var tr = demoListView.find('tr#upload-' + index),
                            tds = tr.children();
                        tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(3).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                },
                error: function (index, upload) {
                    var tr = demoListView.find('tr#upload-' + index),
                        tds = tr.children();
                    tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
    })
</script>

</html>