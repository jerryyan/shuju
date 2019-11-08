<?php

namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Request;
use think\exception\DbException;

class Search extends Controller
{
    public function index()
    {
        if (request()->isPost()) {
            $start = Request::instance()->post('startDate');
            $end = Request::instance()->post('endDate');
            $startDate = $start . " 00:00:00";
            $endDate = $end . " 23:59:59";
            $x_sql = "SELECT xiangmu,cigen,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info  WHERE xiangmu !='' and atime >=? and atime <=? GROUP BY xiangmu ORDER BY azmxf  DESC";
            $all_list = db::query($x_sql, [$startDate, $endDate]);
            $data = array();
            foreach ($all_list as $k => $v) {
                $data[$k]['id'] = $v['xiangmu'] == '远大肛肠' ? 1 : 2;
                $data[$k]['pid'] = 0;
                $data[$k]['title'] = $v['xiangmu'];
                $data[$k]['xf'] = $v['azmxf'];
                $data[$k]['zx'] = $v['azx'];
                $data[$k]['click'] = $v['aclick'];
                $data[$k]['fanwen'] = $v['afw'];
                $data[$k]['duihua'] = $v['adh'];
                $data[$k]['youxiao'] = $v['ayx'];
                $data[$k]['liulian'] = $v['aliulian'];
                $data[$k]['djl'] = $this->getRound($v['aclick'], $v['azx'], 1);
                $data[$k]['ddl'] = $this->getRound($v['afw'],  $v['aclick'], 1);
                $data[$k]['yxzb'] = $this->getRound($v['ayx'], $v['adh'], 1);
                $data[$k]['llv'] = $this->getRound($v['aliulian'], $v['adh'], 1);
                $data[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
                $data[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
                $data[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
                $data[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
            }

            $g_sql = "SELECT xiangmu,cigen,ssword,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info  WHERE xiangmu='远大肛肠' and atime >=? and atime <=? GROUP BY cigen ORDER BY azmxf  DESC";
            $all_list = db::query($g_sql, [$startDate, $endDate]);
            foreach ($all_list as $k => $v) {
                $list[$k]['id'] = $v['cigen'];
                $list[$k]['pid'] = 1;
                $list[$k]['title'] = $v['cigen'];
                $list[$k]['xf'] = $v['azmxf'];
                $list[$k]['zx'] = $v['azx'];
                $list[$k]['click'] = $v['aclick'];
                $list[$k]['fanwen'] = $v['afw'];
                $list[$k]['duihua'] = $v['adh'];
                $list[$k]['youxiao'] = $v['ayx'];
                $list[$k]['liulian'] = $v['aliulian'];
                $list[$k]['djl'] = $this->getRound($v['aclick'], $v['azx'], 1);
                $list[$k]['ddl'] = $this->getRound($v['afw'],  $v['aclick'], 1);
                $list[$k]['yxzb'] = $this->getRound($v['ayx'], $v['adh'], 1);
                $list[$k]['llv'] = $this->getRound($v['aliulian'], $v['adh'], 1);
                $list[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
                $list[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
                $list[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
                $list[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
            }
            $g_list = array_merge($data, $list);

            $w_sql = "SELECT xiangmu,cigen,ssword,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info  WHERE xiangmu='远大胃肠' and atime >=? and atime <=? GROUP BY cigen ORDER BY azmxf  DESC";
            $w_list = db::query($w_sql, [$startDate, $endDate]);
            foreach ($w_list as $k => $v) {
                $wc_list[$k]['id'] = $v['cigen'];
                $wc_list[$k]['pid'] = 2;
                $wc_list[$k]['title'] = $v['cigen'];
                $wc_list[$k]['xf'] = $v['azmxf'];
                $wc_list[$k]['zx'] = $v['azx'];
                $wc_list[$k]['click'] = $v['aclick'];
                $wc_list[$k]['fanwen'] = $v['afw'];
                $wc_list[$k]['duihua'] = $v['adh'];
                $wc_list[$k]['youxiao'] = $v['ayx'];
                $wc_list[$k]['liulian'] = $v['aliulian'];
                $wc_list[$k]['djl'] = $this->getRound($v['aclick'], $v['azx'], 1);
                $wc_list[$k]['ddl'] = $this->getRound($v['afw'],  $v['aclick'], 1);
                $wc_list[$k]['yxzb'] = $this->getRound($v['ayx'], $v['adh'], 1);
                $wc_list[$k]['llv'] = $this->getRound($v['aliulian'], $v['adh'], 1);
                $wc_list[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
                $wc_list[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
                $wc_list[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
                $wc_list[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
            }
            $alist = array_merge($g_list, $wc_list);
            return json_encode($alist);
        } else {

            return view();
        }
    }


    public function export()
    {
        if (request()->isPost()) {
            set_time_limit(0);
            $start = Request::instance()->post('startDate');
            $end = Request::instance()->post('endDate');
            $list = db::query("select * from search_info where atime >=? and atime <=?", [$start, $end]);
            vendor("PHPExcel.PHPExcel");
            $objPHPExcel = new \PHPExcel(); //实例化PHPExcel类       
            $objSheet = $objPHPExcel->getActiveSheet(); //获取当前活动sheet
            //设置标题
            $objSheet->setCellValue("A1", "日期")
                ->setCellValue("B1", "类型")
                ->setCellValue("C1", "项目")
                ->setCellValue("D1", "账户")
                ->setCellValue("E1", "计划")
                ->setCellValue("F1", "单元")
                ->setCellValue("G1", "投放词")
                ->setCellValue("H1", "搜索词")
                ->setCellValue("I1", "展现")
                ->setCellValue("J1", "点击")
                ->setCellValue("K1", "消费")
                ->setCellValue("L1", "访问")
                ->setCellValue("M1", "对话")
                ->setCellValue("N1", "有效")
                ->setCellValue("O1", "留联")
                ->setCellValue("P1", "词大类")
                ->setCellValue("Q1", "来源");
            //填充数据库查询的数据
            $j = 2;
            foreach ($list as $k => $v) {
                $objSheet->setCellValue('A' . $j, $v['atime'])
                    ->setCellValue('B' . $j, $v['stype'])
                    ->setCellValue('C' . $j, $v['xiangmu'])
                    ->setCellValue('D' . $j, $v['zhanghu'])
                    ->setCellValue('E' . $j, $v['jihua'])
                    ->setCellValue('F' . $j, $v['dy'])
                    ->setCellValue('G' . $j, $v['tfword'])
                    ->setCellValue('H' . $j, $v['ssword'])
                    ->setCellValue('I' . $j, $v['zx'])
                    ->setCellValue('J' . $j, $v['click'])
                    ->setCellValue('K' . $j, $v['zmxf'])
                    ->setCellValue('L' . $j, $v['fanwwen'])
                    ->setCellValue('M' . $j, $v['duihua'])
                    ->setCellValue('N' . $j, $v['youxiao'])
                    ->setCellValue('O' . $j, $v['liulian'])
                    ->setCellValue('P' . $j, $v['cigen'])
                    ->setCellValue('Q' . $j, $v['source']);
                $j++;
            }
            $outfile = $start . '到' . $end . "搜索词数据.csv";
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'csv');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器数据excel07文件
            header('Content-Disposition: attachment;filename="' . $outfile . '"'); //告诉浏览器将输出文件的名称
            header('Cache-Control: max-age=0'); //禁止缓存
            $objWriter->save('php://output');
            $xlsdata = ob_get_contents();
            ob_end_clean();
            return ['filename' => $outfile, 'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsdata)];
        }
    }
    public function exportCsv()
    {
        set_time_limit(0);// 设置不超时
ini_set('memory_limit', '1024M');// 设置最大内存 导出一百万如果不设置为1024 则导出不了
set_exception_handler(function ($error) {
        echo 1;
        exit;
});
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        $data = [
                "code" => $errno,
                "msg"  => $errstr,
                "file" => $errfile,
                "line" => $errline,
        ];
        print_r($data);
        echo "<br/>";
        exit;
});
register_shutdown_function(function () {
        $error = error_get_last();
        if ($error) {
                $errno   = $error["type"];
                $errfile = $error["file"];
                $errline = $error["line"];
                $errstr  = $error["message"];
                $data    = [
                        "code" => $errno,
                        "msg"  => $errstr,
                        "file" => $errfile,
                        "line" => $errline,
                ];
                print_r($data);
                exit;
        }
});
$model = new Qushu();
echo date("H:i:s",time())."<br/>";
$model->getDg();
echo date("H:i:s",time())."<br/>";
class Qushu {
        public function getDg() {
                $header = [
                        'id',
                        'uid',
                        'user_name',
                        'url',
                        'request_type',
                        'parameter',
                        'ip',
                        'type',
                        'time',
                        'agent'
                ];
                $output = $this->csvSet("导出表名", $header);
                $data   = $this->getCsv();
                $i = 0;
                foreach ($data as $k => $v) {
                        //输出csv内容
                        fputcsv($output, array_values($v));
                        $i++;
                }
                //关闭文件句柄
                fclose($output) or die("can‘t close php://output");
        }

        /**
         *获取csv内容 使用 yield
         */
        public function getCsv() {
                $mysql = $dbh = new PDO('mysql:host=localhost;dbname=test', "root", "mysqlpw", [
                        PDO::ATTR_PERSISTENT => true
                ]);;
                $data = $mysql->query("select * from wclothing_log limit 1000000");
                // 这里还可以继续优化，我们前面设置了最大的内存是1024M就是因为这里一下子从数据库读取了100W数据
                // 我们还是可以分页获取 比如十万取一次
                foreach ($data as $key => $val) {
                        $a = [
                                $val['id'],
                                $val['uid'],
                                $val['user_name'],
                                $val['url'],
                                $val['request_type'],
                                $val['parameter'],
                                $val['ip'],
                                $val['type'],
                                $val['time'],
                                $val['agent']
                        ];
                        yield $a;// 如果不了解生成器的同学、先去了解yield
                }
        }

        /**设置csv*/
        public function csvSet($name, $head) {
                try {
                        //设置内存占用
                        //为fputcsv()函数打开文件句柄
                        $output = fopen('php://output', 'w') or die("can‘t open php://output");
                        //告诉浏览器这个是一个csv文件
                        header("Content-Type: application/csv");
                        header("Content-Disposition: attachment; filename=$name.csv");
                        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
                        header('Expires:0');
                        header('Pragma:public');
                        // 文件名转码
                        $name = iconv('utf-8', 'gbk', $name);
                        //输出表头
                        foreach ($head as $i => $v) {
                                //CSV的Excel支持GBK编码，一定要转换，否则乱码
                                $head[$i] = iconv('utf-8', 'gbk', $v);
                        }
                        fputcsv($output, $head);
                        return $output;
                } catch (Exception $e) {
                }
        }
}
--------------------- 
版权声明：本文为CSDN博主「清悟-LLH」的原创文章，遵循CC 4.0 by-sa版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/qq_16142851/article/details/83865839
     }

    public function getRound($a, $b, $c = 0)
    {
        if ($c == 1) {
            if ($b == 0) {
                return round($a, 1);
            } else {
                $i = round($a / $b * 100, 1) . "％";
                return $i;
            }
        } else {
            if ($b == 0) {
                return round($a, 1);
            } else {
                $i = round($a / $b, 1);
                return $i;
            }
        }
    }

    public function show()
    {
        $list = db('search')->order('id', 'desc')->select();
        $this->assign('list', $list);
        return view();
    }



    public function add()
    {
        if (request()->isPost()) {
            $post = Request::instance()->post();
            $time = date('Y-m-d H:i:s');
            foreach ($post['guizeOne'] as $k => $v) {
                $data['xiangmu'] = $post['xiangmu'];
                $data['cigen'] = $post['cigen'];
                $data['guize'] = $v;
                $data['atime'] =   $time;
                $res = db('search')->insert($data);
            }
            if ($res) {
                return json(['code' => 1, 'msg' => '添加成功!']);
            } else {
                return json(['code' => 0, 'msg' => '添加失败!']);
            }
        }
    }

    public function editInfo()
    {
        if (request()->isPost()) {
            $id = Request::instance()->post('id');
            $res = db('search')->where('id', $id)->find();
            return json_encode($res);
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $post = Request::instance()->post();
            $time = date('Y-m-d H:i:s');
            $id = $post['id'];
            $data['xiangmu'] =   $post['xiangmu'];
            $data['cigen'] =   $post['cigen'];
            $data['guize'] =   $post['guize'];
            $data['atime'] =   $time;
            $res = db('search')->where('id', $id)->update($data);
            if ($res) {
                return json(['code' => 1, 'msg' => '修改成功!']);
            } else {
                return json(['code' => 0, 'msg' => '修改失败!']);
            }
        }
    }

    public function del()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('search')->delete($id);
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功!']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败!']);
        }
    }


    /**
     * 解析url中参数信息，返回utm字符串
     *
     * @param string
     * @return string
     */
    public function getUtm($url)
    {
        if (stripos($url, 'utm_source=') !== false) {
            // $url = str_replace("?&", "?", $url);
            // $arr = parse_url($url);           
            $queryParts = explode('utm_source=', $url);
            $res = explode('&', $queryParts[1]);
            $new_res = trim($res[1], '=');
            $arr = explode('#', $new_res);
            $str = $res[0] . '&' . $arr[0];
            return $str;
        }
    }
}