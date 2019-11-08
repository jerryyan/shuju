<?php

namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Request;
use think\exception\DbException;

class Index extends Controller
{
    public function index()
    {
        return view();
    }

    public function swtImport()
    {
        if (request()->isPost()) {
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');

            if ($info) {
                //获取文件所在目录名
                $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel/' . $info->getSaveName();
               $uniqid=self::getUniqid;
                //添加上传文件记录到数据库
                $time = date('Y-m-d H:i:s');
                $file_name = $info->getInfo('name');
                $file_data = ['name' => $file_name, 'atime' => $time];
                //获取上传的文件id
                $fid = Db::name('swt_file')->insertGetId($file_data);
                if (strpos($file_name, 'KWD') !== false) {
                    $source = 'KWD';
                } else if (strpos($file_name, 'PFT') !== false) {
                    $source = 'PFT';
                } else if (strpos($file_name, 'DHT') !== false) {
                    $source = 'DHT';
                } else {
                    $source = 'PKT';
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
                    // $PHPReader->setInputEncoding('GBK');
                    //默认的分隔符
                    $PHPReader->setDelimiter(',');
                    //载入文件
                    $objPHPExcel = $PHPReader->load($path);
                }
                $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数

                //将表格里面的数据循环到数组中
                for ($i = 4; $i <= $highestRow; $i++) {
                    $data['bh'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                    $stime = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                    $dtime = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                    $data['stime'] = date('Y-m-d H:i:s', strtotime($stime));
                    $data['dtime'] = date('Y-m-d H:i:s', strtotime($dtime));
                    $data['dhsc'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                    $data['dtype'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                    $data['startfs'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                    $data['endfs'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                    $data['krxxs'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                    $data['kfxxs'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                    $data['mc'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                    $data['kfjds'] = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getValue();
                    $data['kftype'] = $objPHPExcel->getActiveSheet()->getCell("L" . $i)->getValue();
                    $data['system'] = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getValue();
                    $data['yjsf'] = $objPHPExcel->getActiveSheet()->getCell("N" . $i)->getValue();
                    $data['dhly'] = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                    $data['fyly'] = $objPHPExcel->getActiveSheet()->getCell("P" . $i)->getValue();
                    $data['fwwz'] = $objPHPExcel->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $data['krsm'] =  $objPHPExcel->getActiveSheet()->getCell("R" . $i)->getValue();
                    $data['keyword'] = $objPHPExcel->getActiveSheet()->getCell("S" . $i)->getValue();
                    $data['ipaddress'] = $objPHPExcel->getActiveSheet()->getCell("T" . $i)->getValue();
                    $data['ccjdkf'] = $objPHPExcel->getActiveSheet()->getCell("U" . $i)->getValue();
                    $data['fbl'] = $objPHPExcel->getActiveSheet()->getCell("V" . $i)->getValue();
                    $data['cyyqkf'] = $objPHPExcel->getActiveSheet()->getCell("W" . $i)->getValue();
                    $data['ymfws'] = $objPHPExcel->getActiveSheet()->getCell("X" . $i)->getValue();
                    $data['remarks'] = $objPHPExcel->getActiveSheet()->getCell("Y" . $i)->getValue();
                    $data['ip'] = $objPHPExcel->getActiveSheet()->getCell("Z" . $i)->getValue();
                    $data['fid'] = $fid;
                    $data['source'] = $source;
                    $data['utm'] = $this->getUtm($data['fwwz']);
                    // 这里的数据根据自己表格里面有多少个字段自行决定
                    $res = Db::name('swt')->insert($data);
                    // unset($data); //销毁插入的数据数组

                }
                // 往数据库添加数据
                // $res = Db::name('swt')->insertAll($data);
                // $res = Db::name('swt')->fetchSql()->insertAll($data);
                //  return json_encode($res);
                //  halt($res);
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

    public function test()
    {
        return view();
    }
    public function getUniqid()
    {
        return uniqid() . rand(1, 100000);
    }

    public function swtFile()
    {
        $p = Request::instance()->get('p');
        if (empty($p)) {
            $p = 1;
        }
        $count = db('swt_file')->count();
        //每页显示条数
        $limit = 10;
        $index = ($p - 1) * $limit;
        $data = db('swt_file')->limit($index, $limit)->order('id', 'desc')->select();
        $this->assign('p', $p);
        $this->assign('limit', $limit);
        $this->assign('count', $count);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function del()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('swt_file')->delete($id);
        Db::table('swt')->where('fid', $id)->delete();
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
            $url = str_replace("utm_source=utm_source=", "utm_source=", $url);
            $queryParts = explode('utm_source=', $url);
            $res = explode('&', $queryParts[1]);
            $new_res = trim($res[1], '=');
            $arr = explode('#', $new_res);
            $str = $res[0] . '&' . $arr[0];
            return $str;
        } else {
            return '';
        }
    }
}
