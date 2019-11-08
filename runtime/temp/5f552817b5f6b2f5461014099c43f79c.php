<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\WWW\shuju\public/../application/index\view\search\show.html";i:1566461859;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
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
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>序号</th>
                        <td>项目</td>
                        <th>词根</th>
                        <th>搜索词汇总规则</th>
                        <th>添加时间</th>
                        <th>编辑</th>
                    </tr>
                </thead>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tbody class="tb">
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['xiangmu']; ?></td>
                        <td><?php echo $vo['cigen']; ?></td>
                        <td><?php echo $vo['guize']; ?></td>
                        <td><?php echo $vo['atime']; ?></td>
                        <td>
                            <button type="button" onclick="update(<?php echo $vo['id']; ?>)"
                                class="layui-btn layui-btn-xs">修改</button>&nbsp;&nbsp;
                            <button type="button" onclick="deleted(<?php echo $vo['id']; ?>)" class="layui-btn layui-btn-xs">删除</button>
                        </td>
                    </tr>
                </tbody>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <div class="layui-row layui-col-space18">
                <div class="layui-col-md2">
                    <input type="text" name="title" placeholder="请输入词根" class="layui-input chigen">
                </div>
                <div class="layui-col-md2">
                    <input type="text" placeholder="请输入搜索词汇总规则" class="layui-input guizeOne">
                </div>
                <div class="layui-col-md1">
                    <button id="btn" type="button" class="layui-btn  layui-btn-xs">添加多个词汇规则</button>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-tab" lay-filter="demo" lay-allowclose="true" style="margin: 0;">
                        <ul class="layui-tab-title" id="uls" style="margin-bottom: 0;">
                            <!-- <li>用户管理</li> -->
                        </ul>
                    </div>
                </div>
                <div class="layui-col-md2">
                    <select class="form-control xiangmu">
                        <option value="0">请选择项目</option>
                        <option>远大肛肠</option>
                        <option>远大胃肠</option>
                    </select>
                </div>
                <div class="layui-col-md3">
                    <button id="btn2" type="button" class="layui-btn layui-btn-normal">确定新增</button>
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
<script type="text/html" id="updateChiTiao">
    <form class="layui-form" style="padding: 20px;">
        <input id="id" type="hidden" class="layui-input">
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:120px;padding:9px 0;;">项目名称</label>
            <div class="layui-input-block" style="margin-left:160px;">
                <input id="xiangmu" type="text" placeholder="请输入项目名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:120px">词根</label>
            <div class="layui-input-block" style="margin-left:160px;">
                <input id="chigen" type="text" placeholder="请输入词根" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style="width:120px;padding:9px 0;;">搜索词汇总规则</label>
            <div class="layui-input-block" style="margin-left:160px;">
                <input id="guize" type="text" placeholder="请输入新密码" class="layui-input">
            </div>
        </div>

    </form>
</script>
<script>
    layui.use(['table', 'element', 'form'], function () {
        var element = layui.element
        var table = layui.table
        var $ = layui.jquery

        $('#btn').click(function () {
            if ($('.guizeOne').val() == '') {
                layer.msg('搜索词汇不能为空!');
                return
            }
            $('#uls').append(`<li>${$('.guizeOne').val()}</li>`);
            element.init()
            $('.guizeOne').val('')
        })

        $('#btn2').click(function () {
            var guizeOne = []
            $.each($('#uls>li'), function (indexInArray, valueOfElement) {
                var ccc = $(valueOfElement).text()
                ccc = ccc.substr(0, ccc.length - 1)
                guizeOne.push(ccc)
            });
            if ($('.chigen').val() == '') {
                layer.msg('词根不能为空!');
                return
            }
            if (guizeOne.length == 0) {
                layer.msg('搜索词汇不能为空!');
                return
            }
            if ($('.xiangmu').val() == '0') {
                layer.msg('项目名不能为空!');
                return
            }
            var data = {
                cigen: $('.chigen').val(),
                guizeOne: guizeOne,
                xiangmu: $('.xiangmu').val()
            }
            $.ajax({
                type: "post",
                url: "/search/add",
                data: data,
                dataType: "json",
                success: function (res) {
                    layer.msg(res.msg);
                    location.reload();
                }
            });
        })
    })

    function update(val) {

        var $ = layui.jquery
        var form = layui.form
        layer.open({
            type: 1,
            area: ['50%', '60%'],
            content: $('#updateChiTiao').html(),
            btn: ['确定', '取消'],
            success: function (layero, index) {
                form.render();
                $.ajax({
                    type: "post",
                    dataType: "JSON",
                    data: {
                        id: val
                    },
                    url: '/search/editInfo',
                    success: function (response) {
                        var asd = JSON.parse(response);
                        $('#id').val(asd.id)
                        $('#chigen').val(asd.cigen);
                        $('#guize').val(asd.guize);
                        $('#xiangmu').val(asd.xiangmu);
                    }
                });
            },
            yes: function (layero, index) {
                var sub = {
                    id: $('#id').val(),
                    cigen: $('#chigen').val(),
                    guize: $('#guize').val(),
                    xiangmu: $('#xiangmu').val(),
                }
                $.ajax({
                    type: "post",
                    dataType: "JSON",
                    data: sub,
                    url: '/search/edit',
                    success: function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    }
                });
            },
        });

    }

    function deleted(id) {
        var $ = layui.jquery
        layer.open({
            type: 1,
            content: '<p style="text-align: center">确定删除吗?</p>',
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                $.ajax({
                    type: "post",
                    dataType: "JSON",
                    data: {
                        id: id
                    },
                    url: '/search/del',
                    success: function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    }
                });
            },
        });
    }
</script>

</html>