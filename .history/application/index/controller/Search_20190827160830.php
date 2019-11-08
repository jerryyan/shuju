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
            $search = db('search')->where("xiangmu", '远大肛肠')->order('id', 'desc')->select();

            foreach ($search as $k => $v) {
                $cigen_arr[$v['guize']] = $v['cigen'];
            }

            $g_sql = "SELECT * FROM search_info  WHERE xiangmu='远大肛肠' and atime >=? and atime <=?  ORDER BY id  DESC";
            $all_list = db::query($g_sql, [$startDate, $endDate]);
            $list = array();
         
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
                $list[$k]['dhl'] =  $this->getRound($v['adh'], $v['afw'], 1);
                $list[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
                $list[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
                $list[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
                $list[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
            }


            return json_encode($list);
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
            $list = db::query("select * from search_info where  xiangmu!='' and atime >=? and atime <=?", [$start, $end]);
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
        set_time_limit(0);  //防止请求超时   
        $start = Request::instance()->get('startDate');
        $end = Request::instance()->get('endDate');
        $startDate = $start . " 00:00:00";
        $endDate = $end . " 23:59:59";
        $title = [
            "日期",
            "类型",
            "项目",
            "账户",
            "计划",
            "单元",
            "投放词",
            "搜索词",
            "展现",
            "点击",
            "消费",
            "访问",
            "对话",
            "有效",
            "留联",
            "词大类",
            "ip",
            "初次接待客服",
            "来源" //excel 表头
        ];
        // $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel/';   //定义下载文件路
        //  $outfile = '搜索词数据.csv';
        $csvFileName = $start . '到' . $end . "搜索词数据";

        $list = db::query("select * from search_info where atime >=? and atime <=?", [$startDate, $endDate]);
        foreach ($list as $k => $v) {
            $rowData[$k] = [
                $v['atime'],
                $v['stype'],
                $v['xiangmu'],
                $v['zhanghu'],
                $v['jihua'],
                $v['dy'],
                $v['tfword'],
                $v['ssword'],
                $v['zx'],
                $v['click'],
                $v['zmxf'],
                $v['fanwwen'],
                $v['duihua'],
                $v['youxiao'],
                $v['liulian'],
                $v['cigen'],
                $v['ip'],
                $v['ccjdkf'],
                $v['source']
            ];
        }
        $this->toExcel($rowData, $title, $csvFileName, "php://output");
    }


    /**
     * 导出Excel数据表格
     * @param  array    $dataList     要导出的数组格式的数据
     * @param  array    $headList     导出的Excel数据第一列表头
     * @param  string   $fileName     输出Excel表格文件名
     * @param  string   $exportUrl    直接输出到浏览器or输出到指定路径文件下
     * @return bool|false|string
     */
    public  function toExcel($dataList, $headList, $fileName, $exportUrl)
    {
        //set_time_limit(0);//防止超时
        //ini_set("memory_limit", "512M");//防止内存溢出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
        header('Cache-Control: max-age=0');
        //打开PHP文件句柄,php://output 表示直接输出到浏览器,$exportUrl表示输出到指定路径文件下
        $fp = fopen($exportUrl, 'a');

        //输出Excel列名信息
        foreach ($headList as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $headList[$key] = iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $headList);

        //计数器
        $num = 0;

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;

        //逐行取出数据，不浪费内存
        $count = count($dataList);
        for ($i = 0; $i < $count; $i++) {

            $num++;

            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }

            $row = $dataList[$i];
            foreach ($row as $key => $value) {
                $row[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $row);
        }
        return $fileName;
    }


    public function getRound($a, $b, $c = 0)
    {
        if ($c == 1) {
            if ($b == 0) {
                // return round($a, 1);
                return 0;
            } else {
                $i = round($a / $b * 100, 1) . "％";
                return $i;
            }
        } else {
            if ($b == 0) {
                // return round($a, 1);
                return 0;
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
