<?php

namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Request;
use think\exception\DbException;

class Sousuo extends Controller
{
    public function index()
    {
        // $p = Request::instance()->get('p');
        // if (empty($p)) {
        //     $p = 1;
        // }
        // $count = db('swt_file')->count();
        // //每页显示条数
        // $limit = 10;
        // $index = ($p - 1) * $limit;
        // $data = db('swt_file')->limit($index, $limit)->select();
        // $this->assign('p', $p);
        // $this->assign('limit', $limit);
        // $this->assign('count', $count);
        // $this->assign('data', $data);
        // return $this->fetch();
        $data = db('ss_file')->order('id', 'desc')->select();
        $this->assign('data', $data);
        return $this->fetch();
    }


    public function swtData()
    {
        $timer = Request::instance()->post('timer');
        $swt = db::query("select * from swt where left(stime,10)='{$timer}'");
        if (count($swt) < 1) {
            return json(['code' => 0, 'msg' => "请上传{$timer}的商务通数据!"]);
        }
        // $jinjia = db::query("select * from jinjia where left(atime,10)='{$timer}'");
        // if (count($jinjia) < 1) {
        //     return json(['code' => 0, 'msg' => "请上传{$timer}的竞价数据!"]);
        // }

        $info = db::query("select * from search_info where stype='swt' and left(atime,10)='{$timer}'");
        if (count($info) >= 1) {
            return json(['code' => 0, 'msg' => "请先删除{$timer}已经处理的数据!"]);
        }

        $search = db('search')->where('cigen','屁股类')->order('id', 'asc')->select();
        $m_data = db::query("select *,a.keyword as ssword,b.keyword as tfword,left(stime,10) as swt_time from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.mutm where  fwwz like '%utm_source=bdm%' and left(stime,10)='{$timer}' GROUP BY a.id");
        $p_data = db::query("select *,a.keyword as ssword,b.keyword as tfword from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.putm where  fwwz like '%utm_source=bdp%' and left(stime,10)='{$timer}' GROUP BY a.id");
        $list = array_merge($m_data, $p_data);
        $data = array();
        $time = date('Y-m-d H:i:s');
        $file_data = ['stime' => $timer, 'atime' => $time];
        //获取id
        $tid = Db::name('set_file')->insertGetId($file_data);
        foreach ($list as $k => $v) {
            $data[$k]['tid'] = $tid;
            $data[$k]['atime'] = $v['stime'];
            $data[$k]['stype'] = 'swt';
            $data[$k]['xiangmu'] = $v['xiangmu'];
            $data[$k]['zhanghu'] = $v['zhanghu'];
            $data[$k]['jihua'] = $v['jihua'];
            $data[$k]['dy'] = $v['dy'];
            $data[$k]['source'] = $v['source'];
            $data[$k]['tfword'] = $v['tfword'];
            $data[$k]['ssword'] = $v['ssword'];
            $data[$k]['ip'] = $v['ip'];
            $data[$k]['ccjdkf'] = $v['ccjdkf'];
            // $data[$k]['zx'] = $v['zx'];
            // $data[$k]['click'] = $v['click'];
            // $data[$k]['zmxf'] = $v['zmxf'];
            $data[$k]['zx'] = 0;
            $data[$k]['click'] = 0;
            $data[$k]['zmxf'] = 0;
            $data[$k]['fanwwen'] = 1;
            if (stripos($v['dtype'], '一般') !== false || stripos($v['dtype'], '极佳') !== false || stripos($v['dtype'], '较好') !== false) {
                $data[$k]['duihua'] = 1;
            } else {
                $data[$k]['duihua'] = 0;
            }
            if ($v['krxxs'] > 2 && stripos($v['remarks'], '有效1') !== false) {
                $data[$k]['youxiao'] = 1;
            } else {
                $data[$k]['youxiao'] = 0;
            }

            if ($v['krxxs'] > 2 && stripos($v['remarks'], '留联1') !== false) {
                $data[$k]['liulian'] = 1;
            } else {
                $data[$k]['liulian'] = 0;
            }
            $v['ssword']='肛裂能自愈吗';

            foreach ($search as  $vv) {
                if ($v['xiangmu'] == $vv['xiangmu']) {
                    if (stripos($vv['guize'], '*') !== false) {
                        $kk_arr = explode('*', $vv['guize']);
                        if (stripos($v['ssword'], $kk_arr[0]) !== false && stripos($v['ssword'], $kk_arr[1]) !== false) {
                            $cigen = $vv['cigen'];
                        }
                    } else {
                        if (stripos($v['ssword'], $vv['guize']) !== false) {
                            $cigen = $vv['cigen'];
                        }
                    }
                }
                if (!isset($cigen)) {
                    $cigen = '其他';
                }
            }
            $data[$k]['cigen'] = $cigen;
        }
        // halt($data);



        $res = Db::name('search_info')->insertAll($data);
        if ($res) {
            return json(['code' => 1, 'msg' => '数据处理成功!']);
        } else {
            return json(['code' => 0, 'msg' => '数据处理失败!']);
        }
    }

    public function set()
    {
        return view();
    }

    public function show()
    {
        $p = Request::instance()->get('p');
        if (empty($p)) {
            $p = 1;
        }
        $count = db('ss_file')->count();
        //每页显示条数
        $limit = 10;
        $index = ($p - 1) * $limit;
        $data = db('ss_file')->limit($index, $limit)->order('id', 'desc')->select();
        $this->assign('p', $p);
        $this->assign('limit', $limit);
        $this->assign('count', $count);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function setinfo()
    {
        $p = Request::instance()->post('pageIndex');
        if (empty($p)) {
            $p = 1;
        }
        $count = db('set_file')->count();
        //每页显示条数
        $limit = 20;
        $index = ($p - 1) * $limit;
        $data = db('set_file')->limit($index, $limit)->order('id', 'desc')->select();
        return json(['code' => 1, 'msg' => '数据处理成功!', 'data' => $data, 'count' => $count, 'limit' => $limit]);
    }

    public function swtImport()
    {
        if (request()->isPost()) {
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');

            if ($info) {
                $search = db('search')->order('id', 'desc')->select();
                $xiangmu = Request::instance()->post('xiangmu');
                $source = Request::instance()->post('qudao');
                //获取文件所在目录名
                $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel/' . $info->getSaveName();
                //添加上传文件记录到数据库
                $time = date('Y-m-d H:i:s');
                $file_name = $info->getInfo('name');
                $file_data = ['xiangmu' => $xiangmu, 'source' => $source, 'name' => $file_name, 'atime' => $time];
                //获取上传的文件id
                $sid = Db::name('ss_file')->insertGetId($file_data);
                if ($source == '搜狗') {
                    $arr = explode('_统计报告', $file_name);
                    $zhanghu = $arr[0];
                }
                //加载PHPExcel类
                vendor("PHPExcel.PHPExcel");
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if ($extension == 'xlsx') {
                    $objReader = new \PHPExcel_Reader_Excel2007();
                    $objPHPExcel = $objReader->load($path);
                } else if ($extension == 'xls') {
                    $objReader = new \PHPExcel_Reader_Excel5();
                    $objPHPExcel = $objReader->load($path);
                } else if ($extension == 'csv') {
                    $PHPReader = new \PHPExcel_Reader_CSV();
                    //默认输入字符集
                    $PHPReader->setInputEncoding('GBK');
                    //默认的分隔符
                    $PHPReader->setDelimiter(',');
                    //载入文件
                    $objPHPExcel = $PHPReader->load($path);
                }
                $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                $a = 0;
                $data = array();
                //将表格里面的数据循环到数组中
                if ($source == '百度') {
                    for ($i = 9; $i <= $highestRow; $i++) {
                        $data[$a]['atime'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                        $data[$a]['xiangmu'] =  $xiangmu;
                        $data[$a]['stype'] = 'cpc';
                        $data[$a]['zhanghu'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                        $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                        $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                        $data[$a]['tfword'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                        $ssword = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                        $data[$a]['ssword'] = $ssword;
                        $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                        $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                        $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                        $data[$a]['fanwwen'] = 0;
                        $data[$a]['duihua'] = 0;
                        $data[$a]['youxiao'] = 0;
                        $data[$a]['liulian'] = 0;
                        $data[$a]['sid'] = $sid;
                        $data[$a]['source'] = $source;
                        foreach ($search as $kk => $vv) {
                            if ($xiangmu == $vv['xiangmu']) {
                                if (stripos($vv['guize'], '*') !== false) {
                                    $kk_arr = explode('*', $vv['guize']);
                                    if (stripos($ssword, $kk_arr[0]) !== false && stripos($ssword, $kk_arr[1]) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                } else {
                                    if (stripos($ssword, $vv['guize']) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                }
                            }
                            if (!isset($cigen)) {
                                $cigen = '其他';
                            }
                        }
                        $data[$a]['cigen'] = $cigen;
                        $a++;
                    }
                } else if ($source == '神马') {
                    for ($i = 2; $i <= $highestRow; $i++) {
                        $data[$a]['atime'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                        $data[$a]['xiangmu'] =  $xiangmu;
                        $data[$a]['stype'] = 'cpc';
                        $data[$a]['zhanghu'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                        $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                        $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                        $data[$a]['tfword'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                        $ssword = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                        $data[$a]['ssword'] = $ssword;
                        $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                        $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                        $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getValue();
                        $data[$a]['fanwwen'] = 0;
                        $data[$a]['duihua'] = 0;
                        $data[$a]['youxiao'] = 0;
                        $data[$a]['liulian'] = 0;
                        $data[$a]['sid'] = $sid;
                        $data[$a]['source'] = $source;
                        foreach ($search as $kk => $vv) {
                            if ($xiangmu == $vv['xiangmu']) {
                                if (stripos($vv['guize'], '*') !== false) {
                                    $kk_arr = explode('*', $vv['guize']);
                                    if (stripos($ssword, $kk_arr[0]) !== false && stripos($ssword, $kk_arr[1]) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                } else {
                                    if (stripos($ssword, $vv['guize']) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                }
                            }
                            if (!isset($cigen)) {
                                $cigen = '其他';
                            }
                        }
                        $data[$a]['cigen'] = $cigen;
                        $a++;
                    }
                } else if ($source == '360') {
                    for ($i = 2; $i <= $highestRow; $i++) {
                        $atime = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                        $data[$a]['atime'] = substr($atime, 0, 11);
                        $data[$a]['xiangmu'] =  $xiangmu;
                        $data[$a]['stype'] = 'cpc';
                        $data[$a]['zhanghu'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                        $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                        $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                        $data[$a]['tfword'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                        $ssword = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                        $data[$a]['ssword'] = $ssword;
                        $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                        $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                        $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                        $data[$a]['fanwwen'] = 0;
                        $data[$a]['duihua'] = 0;
                        $data[$a]['youxiao'] = 0;
                        $data[$a]['liulian'] = 0;
                        $data[$a]['sid'] = $sid;
                        $data[$a]['source'] = $source;
                        foreach ($search as $kk => $vv) {
                            if ($xiangmu == $vv['xiangmu']) {
                                if (stripos($vv['guize'], '*') !== false) {
                                    $kk_arr = explode('*', $vv['guize']);
                                    if (stripos($ssword, $kk_arr[0]) !== false && stripos($ssword, $kk_arr[1]) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                } else {
                                    if (stripos($ssword, $vv['guize']) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                }
                            }
                            if (!isset($cigen)) {
                                $cigen = '其他';
                            }
                        }
                        $data[$a]['cigen'] = $cigen;
                        $a++;
                    }
                } else if ($source == '搜狗') {
                    for ($i = 3; $i <= $highestRow; $i++) {
                        $data[$a]['atime'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                        $data[$a]['xiangmu'] =  $xiangmu;
                        $data[$a]['stype'] = 'cpc';
                        $data[$a]['zhanghu'] =  $zhanghu;
                        $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                        $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                        $data[$a]['tfword'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                        $ssword = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getValue();
                        $data[$a]['ssword'] = $ssword;
                        $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                        $data[$a]['zx'] = '0';
                        $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("N" . $i)->getValue();
                        $data[$a]['fanwwen'] = 0;
                        $data[$a]['duihua'] = 0;
                        $data[$a]['youxiao'] = 0;
                        $data[$a]['liulian'] = 0;
                        $data[$a]['sid'] = $sid;
                        $data[$a]['source'] = $source;
                        foreach ($search as $kk => $vv) {
                            if ($xiangmu == $vv['xiangmu']) {
                                if (stripos($vv['guize'], '*') !== false) {
                                    $kk_arr = explode('*', $vv['guize']);
                                    if (stripos($ssword, $kk_arr[0]) !== false && stripos($ssword, $kk_arr[1]) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                } else {
                                    if (stripos($ssword, $vv['guize']) !== false) {
                                        $cigen = $vv['cigen'];
                                    }
                                }
                            }
                            if (!isset($cigen)) {
                                $cigen = '其他';
                            }
                        }
                        $data[$a]['cigen'] = $cigen;
                        $a++;
                    }
                } else {
                    return json(['code' => 0, 'msg' => '渠道未选择!']);
                }
                // halt($data);
                // 往数据库添加数据
                $res = Db::name('search_info')->insertAll($data);
                unset($data);
                if ($res) {
                    return json(['code' => 1, 'msg' => '上传成功!']);
                } else {
                    return json(['code' => 0, 'msg' => $info->getError()]);
                }
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
    }




    public function del()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('ss_file')->delete($id);
        Db::table('search_info')->where('sid', $id)->delete();
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功!']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败!']);
        }
    }

    public function swtDel()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('set_file')->delete($id);
        Db::table('search_info')->where('tid', $id)->delete();
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功!']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败!']);
        }
    }

    public function truncate()
    {

        Db::execute("truncate ls_info");
        Db::execute("truncate ls_jinjia");
        Db::execute("truncate ls_jjfile");
        Db::execute("truncate ls_ssfile");
        Db::execute("truncate ls_swt");
        Db::execute("truncate ls_swtfile");
        return json(['code' => 1, 'msg' => '删除成功!']);
    }
}
