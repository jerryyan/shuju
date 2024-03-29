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
            $a_sql = "SELECT cigen,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info where atime >=? and atime <=?  GROUP BY cigen ORDER BY azmxf  DESC";
            $all_list = db::query($a_sql,[,]);
            foreach ($all_list as $k => $v) {
                $data[$k]['id'] = $v['cigen'];
                $data[$k]['pid'] = 0;
                $data[$k]['title'] = $v['cigen'];
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
            return  json_encode($data);
            // $w_sql = "SELECT cigen,ssword,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info  where cigen!='其他' GROUP BY ssword LIMIT 0,1000";
            // $all_list = db::query($w_sql);
            // foreach ($all_list as $k => $v) {
            //     $list[$k]['id'] = $v['ssword'];
            //     $list[$k]['pid'] = $v['cigen'];
            //     $list[$k]['title'] = $v['ssword'];
            //     $list[$k]['xf'] = $v['azmxf'];
            //     $list[$k]['zx'] = $v['azx'];
            //     $list[$k]['click'] = $v['aclick'];
            //     $list[$k]['fanwen'] = $v['afw'];
            //     $list[$k]['duihua'] = $v['adh'];
            //     $list[$k]['youxiao'] = $v['ayx'];
            //     $list[$k]['liulian'] = $v['aliulian'];
            //     $list[$k]['djl'] = $this->getRound($v['aclick'], $v['azx'], 1);
            //     $list[$k]['ddl'] = $this->getRound($v['afw'],  $v['aclick'], 1);
            //     $list[$k]['yxzb'] = $this->getRound($v['ayx'], $v['adh'], 1);
            //     $list[$k]['llv'] = $this->getRound($v['aliulian'], $v['adh'], 1);
            //     $list[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
            //     $list[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
            //     $list[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
            //     $list[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
            // }
            // $list = array_merge($data, $list);


        } else {

            return view();
        }
    }


    public function export()
    {
        $list = db::query("select * from search_info");
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
        $outfile = "搜索词.xlsx";
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器数据excel07文件
        header('Content-Disposition: attachment;filename="' . $outfile . '"'); //告诉浏览器将输出文件的名称
        header('Cache-Control: max-age=0'); //禁止缓存
        $objWriter->save('php://output');
        $xlsdata = ob_get_contents();
        ob_end_clean();
        return ['filename' => $outfile, 'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsdata)];
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
