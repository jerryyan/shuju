<?php

namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Request;
use think\exception\DbException;

class Jinjia extends Controller
{
    public function index()
    {
        return view();
    }

    public function jjImport()
    {
        if (request()->isPost()) {
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');
            if ($info) {
                $source = Request::instance()->post('source');
                $atime = Request::instance()->post('atime');
                $file_name = $info->getInfo('name');
                if ($source == '百度' || $source == '搜狗') {
                    $arr = explode('_关键词', $file_name);
                } else {
                    $arr = explode('.xlsx', $file_name);
                }

                if ($source != "神马" && $source != "360") {
                    $zhanghu = $arr[0];
                    $xiangmu = db('user_info')->where('name', 'like', '%' . $zhanghu . '%')->value('xiangmu');
                }
                $uniqid = $this->getUniqid();
                //获取文件所在目录名
                $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel/' . $info->getSaveName();
                //加载PHPExcel类
                vendor("PHPExcel.PHPExcel");
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if ($extension == 'xlsx' || $extension == 'xls') {
                    if ($extension == 'xlsx') {
                        $objReader = new \PHPExcel_Reader_Excel2007();
                    } else {
                        $objReader = new \PHPExcel_Reader_Excel5();
                    }
                    $objPHPExcel = $objReader->load($path);
                    $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                    $a = 0;
                    if ($source == '百度') {
                        //将表格里面的数据循环到数组中
                        for ($i = 2; $i <= $highestRow; $i++) {
                            $data[$a]['uniqid'] = $uniqid;
                            $data[$a]['zhanghu'] = $zhanghu;
                            $data[$a]['atime'] = $atime;
                            $data[$a]['xiangmu'] = $xiangmu;
                            $data[$a]['source'] = $source;
                            $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                            $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                            $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                            $data[$a]['ppms'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                            $data[$a]['chujia'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                            $data[$a]['pweb'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                            $data[$a]['mweb'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                            $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                            $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("Q" . $i)->getValue();
                            $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("R" . $i)->getValue();
                            $data[$a]['pquality'] = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getValue();
                            $data[$a]['mquality'] = $objPHPExcel->getActiveSheet()->getCell("N" . $i)->getValue();
                            $data[$a]['putm'] = $this->getUtm($data[$a]['pweb']);
                            $data[$a]['mutm'] = $this->getUtm($data[$a]['mweb']);
                            $a++;
                        }
                    } else if ($source == '360') {
                        for ($i = 2; $i <= $highestRow; $i++) {
                            $data[$a]['uniqid'] = $uniqid;
                            $data[$a]['zhanghu'] = $zhanghu;
                            $data[$a]['atime'] = $atime;
                            $data[$a]['xiangmu'] = $xiangmu;
                            $data[$a]['source'] = $source;
                            $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                            $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                            $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                            $data[$a]['ppms'] = '';
                            $data[$a]['chujia'] = '';
                            $data[$a]['pweb'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                            $data[$a]['mweb'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                            $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getValue();
                            $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                            $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                            $data[$a]['pquality'] = '';
                            $data[$a]['mquality'] = '';
                            // $data[$a]['putm'] = $this->getUtm($data[$a]['pweb']);
                            // $data[$a]['mutm'] = $this->getUtm($data[$a]['mweb']);
                            $a++;
                        }
                    } else if ($source == '神马') {
                        for ($i = 2; $i <= $highestRow; $i++) {
                            $zhanghu = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                            $data[$a]['uniqid'] = $uniqid;
                            $data[$a]['zhanghu'] = $zhanghu;
                            $data[$a]['atime'] = $atime;
                            $xiangmu = db('user_info')->where('name', 'like', '%' . $zhanghu . '%')->value('xiangmu');
                            $data[$a]['xiangmu'] = $xiangmu;
                            $data[$a]['source'] = $source;
                            $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                            $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                            $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                            $data[$a]['ppms'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                            $data[$a]['chujia'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                            $data[$a]['pweb'] = "";
                            $data[$a]['mweb'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                            $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getValue();
                            $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("L" . $i)->getValue();
                            $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getValue();
                            $data[$a]['pquality'] = "";
                            $data[$a]['mquality'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                            // $data[$a]['putm'] = $this->getUtm($data[$a]['pweb']);
                            // $data[$a]['mutm'] = $this->getUtm($data[$a]['mweb']);
                            $a++;
                        }
                    }
                } else if ($extension == 'csv') {
                    if ($source == '百度') {
                        $handle = $this->fopen_utf8($path);
                        $data = array();
                        for ($j = 1; !feof($handle); $j++) {
                            $line = fgets($handle);
                            $val = explode("\t", $line);
                            if ($j > 1) {
                                if (count($val) > 1) {
                                    $list['uniqid'] = $uniqid;
                                    $list['zhanghu'] = $zhanghu;
                                    $list['atime'] = $atime;
                                    $list['xiangmu'] = $xiangmu;
                                    $list['source'] = $source;
                                    $list['jihua'] =  $val[0];
                                    $list['dy'] =  $val[1];
                                    $list['keyword'] = $val[2];
                                    $list['ppms'] = $val[3];
                                    $list['chujia'] = $val[4];
                                    $list['pweb'] = $val[5];
                                    $list['mweb'] = $val[6];
                                    $list['zmxf'] = $val[14];
                                    $list['click'] = $val[16];
                                    $list['zx'] = $val[17];
                                    $list['pquality'] = $val[12];
                                    $list['mquality'] = $val[13];
                                    $list['putm'] = $this->getUtm($list['pweb']);
                                    $list['mutm'] = $this->getUtm($list['mweb']);
                                    $data[] = $list;
                                }
                            }
                        }
                    } else if ($source == '搜狗') {
                        $PHPReader = new \PHPExcel_Reader_CSV();
                        //默认输入字符集
                        $PHPReader->setInputEncoding('GBK');
                        //默认的分隔符
                        $PHPReader->setDelimiter(',');
                        //载入文件
                        $objPHPExcel = $PHPReader->load($path);
                        $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                        $highestRow = $sheet->getHighestRow(); // 取得总行数
                        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                        $a = 0;

                        //将表格里面的数据循环到数组中
                        for ($i = 2; $i <= $highestRow; $i++) {
                            $data[$a]['uniqid'] = $uniqid;
                            $data[$a]['zhanghu'] = $zhanghu;
                            $data[$a]['atime'] = $atime;
                            $data[$a]['xiangmu'] = $xiangmu;
                            $data[$a]['source'] = $source;
                            $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                            $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                            $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                            $data[$a]['ppms'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                            $data[$a]['chujia'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                            $data[$a]['pweb'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                            $data[$a]['mweb'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                            $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("P" . $i)->getValue();
                            $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("R" . $i)->getValue();
                            $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("S" . $i)->getValue();
                            $data[$a]['pquality'] = $objPHPExcel->getActiveSheet()->getCell("N" . $i)->getValue();
                            $data[$a]['mquality'] = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getValue();
                            // $data[$a]['putm'] = $this->getUtm($data[$a]['pweb']);
                            // $data[$a]['mutm'] = $this->getUtm($data[$a]['mweb']);
                            $a++;
                        }
                    } else if ($source == '360') {
                        $PHPReader = new \PHPExcel_Reader_CSV();
                        //默认输入字符集
                        $PHPReader->setInputEncoding('GBK');
                        //默认的分隔符
                        $PHPReader->setDelimiter(',');
                        //载入文件
                        $objPHPExcel = $PHPReader->load($path);
                        $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                        $highestRow = $sheet->getHighestRow(); // 取得总行数
                        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                        $a = 0;
                        for ($i = 2; $i <= $highestRow; $i++) {
                            $zhanghu = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                            $data[$a]['uniqid'] = $uniqid;
                            $data[$a]['zhanghu'] = $zhanghu;
                            $data[$a]['atime'] = $atime;
                            $xiangmu = db('user_info')->where('name', 'like', '%' . $zhanghu . '%')->value('xiangmu');
                            $data[$a]['xiangmu'] = $xiangmu;
                            $data[$a]['source'] = $source;
                            $data[$a]['jihua'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                            $data[$a]['dy'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                            $data[$a]['keyword'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                            $data[$a]['ppms'] = '';
                            $data[$a]['chujia'] = '';
                            $data[$a]['pweb'] = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getValue();
                            $data[$a]['mweb'] = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getValue();
                            $data[$a]['zmxf'] = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getValue();
                            $data[$a]['click'] = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getValue();
                            $data[$a]['zx'] = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getValue();
                            $data[$a]['pquality'] = '';
                            $data[$a]['mquality'] = '';
                            $data[$a]['putm'] = $this->getUtm($data[$a]['pweb']);
                            $data[$a]['mutm'] = $this->getUtm($data[$a]['mweb']);
                            $a++;
                        }
                    }
                }
            }

            // halt($data);
            //往数据库添加数据
            $res = Db::name('jinjia')->insertAll($data);
            unset($data);
            if ($res) {
                //添加上传文件记录到数据库
                $time = date('Y-m-d H:i:s');
                $file_data = ['name' => $file_name, 'atime' => $time, 'source' => $source, 'uniqid' => $uniqid];
                //获取上传的文件id
                $uniqid = Db::name('jj_file')->insertGetId($file_data);
                return json(['code' => 1, 'msg' => '上传成功!']);
            } else {
                return json(['code' => 0, 'msg' => $info->getError()]);
            }
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

    /**
     * 返回字符串中的数字
     *
     * @param string $str
     * @return int
     */
    public  function findNum($str = '')
    {
        $str = trim($str);
        if (empty($str)) {
            return '';
        }
        $temp = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $result = '';
        for ($i = 0; $i < strlen($str); $i++) {
            if (in_array($str[$i], $temp)) {
                $result .= $str[$i];
            }
        }
        return $result;
    }
    /**
     * 返回文件数据流
     *
     * @param [type] $filename
     * @return string
     */
    function fopen_utf8($filename)
    {
        $encoding = '';
        $handle = fopen($filename, 'r');
        $bom = fread($handle, 2);
        //    fclose($handle);
        rewind($handle);

        if ($bom === chr(0xff) . chr(0xfe)  || $bom === chr(0xfe) . chr(0xff)) {
            // UTF16 Byte Order Mark present
            $encoding = 'UTF-16';
        } else {
            $file_sample = fread($handle, 1000) + 'e'; //read first 1000 bytes
            // + e is a workaround for mb_string bug
            rewind($handle);

            $encoding = mb_detect_encoding($file_sample, 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
        }
        if ($encoding) {
            stream_filter_append($handle, 'convert.iconv.' . $encoding . '/UTF-8');
        }

        return ($handle);
    }

    public function getUniqid()
    {
        return uniqid() . rand(100, 999);
    }


    public function userImport()
    {
        if (request()->isPost()) {
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');

            if ($info) {
                //获取文件所在目录名
                $path = ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel/' . $info->getSaveName();
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

                //实例化PHPExcel类（注意：实例化的时候前面需要加'\'）/*  */
                // $objReader = new \PHPExcel_Reader_Excel5();
                // $objPHPExcel = $objReader->load($path, $encode = 'utf-8'); //获取excel文件
                $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                $a = 0;
                //将表格里面的数据循环到数组中
                for ($i = 4; $i <= $highestRow; $i++) {
                    $data[$a]['zhbj'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                    $data[$a]['name'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                    $data[$a]['xiangmu'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                    $a++;
                }
                $res = Db::name('user_info')->insertAll($data);
                unset($data);
                if ($res) {
                    return json(['code' => 1, 'msg' => '数据导入成功!']);
                } else {
                    return json(['code' => 0, 'msg' => $info->getError()]);
                }
            }
        }
    }
    public function addUser()
    {
        if (request()->isPost()) {
            $post = Request::instance()->post();
            $res = db('user_info')->insert($post);
            if ($res) {
                return json(['code' => 1, 'msg' => '添加成功!']);
            } else {
                return json(['code' => 0, 'msg' => '添加失败!']);
            }
        } else {
            $list = db('user_info')->select();
            $this->assign('list', $list);
            return view();
        }
    }


    public function jjFile()
    {
        $p = Request::instance()->get('p');
        if (empty($p)) {
            $p = 1;
        }
        $count = db('jj_file')->count();
        //每页显示条数
        $limit = 10;
        $index = ($p - 1) * $limit;
        $data = db('jj_file')->limit($index, $limit)->order('id', 'desc')->select();
        
        $this->assign('p', $p);
        $this->assign('limit', $limit);
        $this->assign('count', $count);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function useDel()
    {
        $id = Request::instance()->post('id');
        $res = Db::table('user_info')->delete($id);
        if ($res) {
            return json(['code' => 1, 'msg' => '删除成功!']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败!']);
        }
    }

    //删除上传的竞价文件
    public function del()
    {
        $uniqid = Request::instance()->post('id');
        $res = Db::table('jj_file')->where('uniqid', $uniqid)->delete();
        Db::table('jinjia')->where('uniqid', $uniqid)->delete();
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
        if (stripos($url, 'source=') !== false) {
            // $url = str_replace("?&", "?", $url);
            // $arr = parse_url($url);           
            $queryParts = explode('source=', $url);
            $str = $queryParts[1];
            return $str;
        } else {
            return '';
        }
    }
}
