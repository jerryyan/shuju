<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\WWW\shuju\public/../application/index\view\jinjia\index.html";i:1564646023;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文件管理</title>
    <link rel="stylesheet" href="/static/assert/layui/css/layui.css">
    <style>
        .qudao {
            width: 180px;
            height: 35px;
            margin-left: 30px;
        }
    </style>
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
                    <select name="qudao" class="qudao">
                        <option selected>请选择渠道</option>
                        <option value="百度">百度</option>
                        <option value="搜狗">搜狗</option>
                        <option value="神马">神马</option>
                        <option value="360">360</option>
                    </select>
                    <div class="layui-inline">
                        <label class="layui-form-label">请选择日期</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input timer" id="test1" placeholder="yyyy-MM-dd">
                        </div>
                    </div>
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
            深圳远大肛肠医院
        </div>
    </div>
    <!--百度搜狗神马360  -->
</body>
<script src="/static/assert/layui/layui.js"></script>
<script>
    layui.use(['upload', 'layedit', 'laydate', 'element'], function () {
        var element = layui.element;
        var $ = layui.jquery;
        var upload = layui.upload;
        var laydate = layui.laydate;
        var layedit = layui.layedit;
        laydate.render({
            elem: '#test1',
            value: new Date()
        });
        var demoListView = $('#demoList'),
            uploadListIns = upload.render({
                elem: '#testList',
                url: '/jinjia/jjImport',
                accept: 'file',
                multiple: true,
                auto: false,
                data: {
                    source: function () {
                        return $('.qudao').val();
                    },
                    atime: function () {
                        return $('.timer').val();
                    }
                },
                bindAction: '#testListAction',
                choose: function (obj) {
                    var files = this.files = obj.pushFile();
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