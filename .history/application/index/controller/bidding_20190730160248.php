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

                //添加上传文件记录到数据库
                $time = date('Y-m-d H:i:s');
                $file_name = $info->getInfo('name');
                $file_data = ['name' => $file_name, 'atime' => $time, 'isdel' => 1];
                //获取上传的文件id
                $fid = Db::name('swt_file')->insertGetId($file_data);
                if (strpos($file_name, 'KWD') !== false) {
                    $source = 'KWD';
                } else if (strpos($file_name, 'PFT') !== false) {
                    $source = 'PFT';
                } else {
                    $source = 'PKT';
                }
                //加载PHPExcel类
                vendor("PHPExcel.PHPExcel");
                //实例化PHPExcel类（注意：实例化的时候前面需要加'\'）/*  */
                $objReader = new \PHPExcel_Reader_Excel5();
                $objPHPExcel = $objReader->load($path, $encode = 'utf-8'); //获取excel文件
                $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                $a = 0;
                //将表格里面的数据循环到数组中
                for ($i = 4; $i <= $highestRow; $i++) {
                    $data[$a]['bh'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                    $data[$a]['stime'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                    $data[$a]['dtime'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                    $data[$a]['dhsc'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                    $data[$a]['dtype'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                    $data[$a]['startfs'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                    $data[$a]['endfs'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                    $data[$a]['krxxs'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                    $data[$a]['kfxxs'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                    $data[$a]['mc'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                    $data[$a]['kfjds'] = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getValue();
                    $data[$a]['kftype'] = $objPHPExcel->getActiveSheet()->getCell("L" . $i)->getValue();
                    $data[$a]['system'] = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getValue();
                    $data[$a]['yjsf'] = $objPHPExcel->getActiveSheet()->getCell("N" . $i)->getValue();
                    $data[$a]['dhly'] = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                    $data[$a]['fyly'] = $objPHPExcel->getActiveSheet()->getCell("P" . $i)->getValue();
                    $data[$a]['fwwz'] = $objPHPExcel->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $data[$a]['krsm'] = $objPHPExcel->getActiveSheet()->getCell("R" . $i)->getValue();
                    $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("S" . $i)->getValue();
                    $data[$a]['ipaddress'] = $objPHPExcel->getActiveSheet()->getCell("T" . $i)->getValue();
                    $data[$a]['ccjdkf'] = $objPHPExcel->getActiveSheet()->getCell("U" . $i)->getValue();
                    $data[$a]['fbl'] = $objPHPExcel->getActiveSheet()->getCell("V" . $i)->getValue();
                    $data[$a]['cyyqkf'] = $objPHPExcel->getActiveSheet()->getCell("W" . $i)->getValue();
                    $data[$a]['ymfws'] = $objPHPExcel->getActiveSheet()->getCell("X" . $i)->getValue();
                    $data[$a]['remarks'] = $objPHPExcel->getActiveSheet()->getCell("Y" . $i)->getValue();
                    $data[$a]['ip'] = $objPHPExcel->getActiveSheet()->getCell("Z" . $i)->getValue();
                    $data[$a]['fid'] = $fid;
                    $data[$a]['source'] = $source;
                    $data[$a]['isdel'] = 1;
                    // 这里的数据根据自己表格里面有多少个字段自行决定
                    $a++;
                }
                // 往数据库添加数据
                $res = Db::name('swt')->insertAll($data);
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


    public function swtFile()
    {
        $p = Request::instance()->get('p');
        if (empty($p)) {
            $p = 1;
        }
        $count = db('swt_file')->where('isdel', 1)->count();
        //每页显示条数
        $limit = 5;
        $index = ($p - 1) * $limit;
        $data = db('swt_file')->where('isdel', 1)->limit($index, $limit)->select();
        $this->assign('p', $p);
        $this->assign('limit', $limit);
        $this->assign('count', $count);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function del()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('swt_file')->where('id', $id)->update(['isdel' => 0]);
        Db::table('swt')->where('fid', $id)->update(['isdel' => 0]);
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功!']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败!']);
        }
    }
}
