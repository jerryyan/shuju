<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\WWW\shuju\public/../application/index\view\search\index.html";i:1567237821;s:52:"D:\WWW\shuju\application\index\view\common\left.html";i:1567066708;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞价搜索词报告</title>
    <link rel="stylesheet" href="/static/assert/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/static/assert/layui/css/layui.css">
    <link rel="stylesheet" href="/static/assert/upt.css">
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">数据统计</div>
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
            <div class="container-fuild" style="padding: 0px 20px;">
                <div class="row">
                    <div class="col-sm-2">
                        <select class="form-control" id="suoyou">
                            <option value="0">所有</option>
                            <option value="1">远大肛肠</option>
                            <option value="2">远大胃肠</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <div class="layui-input-inline">
                            <input type="text" style="width: 100%;" class="layui-input" id="time1"
                                placeholder="yyyy-MM-dd">
                        </div>
                    </div>
                    <!-- <div class="col-sm-2">-----------------------</div> -->
                    <div class="col-sm-2">
                        <div class="layui-input-inline">
                            <input type="text" style="width: 100%;" class="layui-input" id="time2"
                                placeholder="yyyy-MM-dd">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" id="qwer" class="btn btn-success">查询</button>
                    </div>
                    <!-- <div    -->
                    <div class="col-md-1">
                        <button type="button" id="tanTan" class="btn btn-success">更多</button>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success export">下载</button>
                        <!-- <a class="btn btn-success" href="/search/export">下载</a> -->
                    </div>
                    <div class="col-sm-12">
                        <table class="layui-table layui-form layui-anim" id="tree-table1" style="text-align: center;">
                        </table>
                    </div>
                    <div class="biBox" style="display: none">
                        <div style="margin-top: 20px">
                            <div class="topBox" style="display: flex;flex-wrap: wrap;">
                                <div class="box" data-id="1"><span>消费</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="2"><span>展现</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="3"><span>点击</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="4"><span>访问</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="5"><span>对话</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="6"><span>有效</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="7"><span>留联</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="8"><span>点击率</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="9"><span>抵达率</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="10"><span>有效率</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="11"><span>留联率</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                                <div class="box" data-id="12"><span>对话率</span><i
                                        class="layui-icon layui-icon-close-fill"></i>
                                </div>
                            </div>
                            <div style="border: 1px solid #cccccc;margin-bottom: 8px;"></div>
                            <div class="botBox" style="display: flex;flex-wrap: wrap;">
                                <div class="box" data-id="13"><span>点击成本</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="14"><span>对话成本</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="15"><span>有效成本</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="16"><span>留联成本</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="107"><span>消费占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="207"><span>展现占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="307"><span>点击占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="407"><span>访问占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="507"><span>对话占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="607"><span>有效占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                                <div class="box" data-id="707"><span>留联占比</span><i
                                        class="layui-icon layui-icon-add-circle-fine"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-footer">
                <!-- 底部固定区域 -->
                深圳远大肛肠医院
            </div>
        </div>
    </div>
</body>
<script src="/static/assert/jquery-3.3.1.min.js"></script>
<script src="/static/assert/bootstrap/js/bootstrap.js"></script>
<script src="/static/assert/layui/layui.js"></script>
<script src="/static//assert/download.js"></script>
<script>
    layui.config({
        base: '/static/assert/',
    })
    layui.use(["laydate", "element", 'form', 'treeTable', 'layer'], function () {
        var laydate = layui.laydate;
        var element = layui.element;
        var form = layui.form
        var treeTable = layui.treeTable;
        layer = layui.layer;
        laydate.render({
            elem: '#time1',
            value: baseMouth()
        });
        laydate.render({
            elem: '#time2',
            value: lastDay()
        });

        var beif = [{
                key: 'title',
                title: '词根',
            }, {
                key: 'xf',
                title: '消费',
            }, {
                key: 'zx',
                title: '展现',
            }, {
                key: 'click',
                title: '点击',
            }, {
                key: 'fanwen',
                title: '访问',
            }, {
                key: 'duihua',
                title: '对话',
            }, {
                key: 'youxiao',
                title: '有效',
            }, {
                key: 'liulian',
                title: '留联',
            }, {
                key: 'ddl',
                title: '抵达率',
            }, {
                key: 'yxzb',
                title: '有效率',
            }, {
                key: 'llv',
                title: '留联率',
            },
            {
                key: 'dhl',
                title: '对话率',
            }, {
                key: 'djcb',
                title: '点击成本',
            }, {
                key: 'dhcb',
                title: '对话成本',
            }, {
                key: 'yxcb',
                title: '有效成本',
            }, {
                key: 'llxb',
                title: '留联成本',
            },
        ]

        baseAjax()
        var dataA = NaN
        var colser = beif

        $('#qwer').click(function () {
            baseAjax()
        })

        var data = NaN
        var datafub = NaN

        function baseAjax() {
            layer.open({
                type: 3,
            });
            $.ajax({
                type: "post",
                url: "/search/index",
                data: {
                    startDate: $('#time1').val(),
                    endDate: $('#time2').val(),
                    xiangmu: $('#suoyou').val()
                },
                // dataType: 'json',
                success: function (response) {
                    layer.closeAll();
                    data = JSON.parse(response)
                    datafub = $.extend(true, [], data)
                    xuanRan(data, colser)
                }
            });
        }



        // $('#uiop').click(function () {
        //     if ($('#uiop').text() == '百分比显示') {
        //         dispose(data)
        //         $('#uiop').text('数字显示')
        //     } else {
        //         $('#uiop').text('百分比显示')
        //         baseAjax()
        //     }
        // })

        function dispose(data, num) {
            var firstArr = []
            $.each(data, function (index, value) {
                if (value.pid == 0) {
                    firstArr.push(value)
                }
            })
            $.each(firstArr, function (index, value) {
                $.each(data, function (idx, item) {
                    $.each(num, function (a, b) {
                        if (value.id == item.pid) {
                            if (value[b] != 0) {
                                var baifengbi = ((item[b] / value[b]) * 100).toString()
                                    .match(
                                        /^\d+(?:\.\d{0,2})?/) + "%"
                                item[b] = item[b] + '(' + baifengbi + ')'
                            }
                        }
                    })
                })
            })
            $.each(firstArr, function (index, value) {
                $.each(num, function (a, b) {
                    value[b] = value[b] + '(' + 100 + '%' + ')'
                })
            })
        }

        function xuanRan(data, col) {
            // console.log(data);
            treeTable.render({
                elem: '#tree-table1',
                // url: '/search/index',
                data: data,
                icon_key: 'title',
                cols: col
            });

        }


        $('#tanTan').click(function () {
            var colsd = []
            layer.open({
                type: 1,
                title: '更多标签',
                closeBtn: false,
                area: '530px;',
                shade: 0.8,
                id: 'LAY_layuipro',
                btn: ['确定', '取消'],
                btnAlign: 'c',
                moveType: 1,
                content: "<div class='tyu'>" + $('.biBox').html() + "</div>",
                success: function (layero) {
                    appd()
                },
                yes: function () {
                    var zqj = false,
                        nuu = []
                    $.each($('.tyu .topBox').children(), function (idx, item) {
                        if (isInArray($(item).attr('data-id'), ['107', '207', '307',
                                '407', '507', '607', '707'
                            ])) {
                            nuu.push(beif[parseInt($(item).attr('data-id').split(
                                '07')[0])]['key'])
                            zqj = true
                        } else {
                            var num = $(item).attr('data-id')
                            colsd.push(beif[num])
                        }
                    })
                    data = NaN
                    data = JSON.parse(JSON.stringify(datafub))
                    dispose(data, nuu)
                    colsd.unshift(beif[0])
                    colser = colsd
                    if (zqj) {
                        xuanRan(data, colser)
                    } else {
                        xuanRan(datafub, colser)
                    }
                    colser = []
                    layer.closeAll();
                }
            });
        })
    })


    function appd() {
        $('.topBox').on('click', 'i', function () {
            $(this).removeClass('layui-icon-close-fill')
            $(this).addClass('layui-icon-add-circle-fine')
            $(this).parent().appendTo($('.botBox'))
            $('.biBox').html($('.tyu').html())
        })
        $('.botBox').on('click', 'i', function () {
            $(this).removeClass('layui-icon-add-circle-fine')
            $(this).addClass('layui-icon-close-fill')
            $(this).parent().appendTo($('.topBox'))
            $('.biBox').html($('.tyu').html())
        })
    }


    function isInArray(value, arr) {
        for (var i = 0; i < arr.length; i++) {
            if (value === arr[i]) {
                return true;
            }
        }
        return false;
    }

    function baseMouth() {
        var timer = new Date().toISOString().split('T')[0]
        timer = timer.substr(0, timer.length - 2) + '01'
        return timer
    }

    function lastDay() {
        var day1 = new Date();
        day1.setTime(day1.getTime() - 24 * 60 * 60 * 1000);
        var mouth = NaN
        if (day1.getMonth() + 1 >= 10) {
            mouth = day1.getMonth() + 1
        } else {
            mouth = '0' + (day1.getMonth() + 1)
        }
        var s1 = day1.getFullYear() + "-" + mouth + "-" + day1.getDate();
        return s1
    }
    $(".export").click(function () {
        $startDate = $('#time1').val();
        $endDate = $('#time2').val();
        $type = $('#suoyou').val();
        var tempwindow = window.open('_blank');
        tempwindow.location.href = "/search/exportCsv?type=" + $type + "&startDate=" + $startDate +
            "&endDate=" + $endDate;
    });

    // function downloads() {
    //     $.ajax({
    //         type: "post",
    //         url: "/search/exportCsv",
    //         data: {
    //             startDate: $('#time1').val(),
    //             endDate: $('#time2').val()
    //         },
    //         // dataType: "json",
    //         success: function (res) {
    //             var $a = $("<a>");
    //             $a.attr("href", res.file);
    //             $a.attr("download", res.filename);
    //             $("body").append($a);
    //             $a[0].click();
    //             $a.remove();
    //         }

    //     });
    // }
</script>

</html>