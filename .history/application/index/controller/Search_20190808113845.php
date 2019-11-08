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
        $search = db('search')->order('id', 'desc')->select();

        foreach ($search as $k => $v) {
            $cigen_arr[$v['guize']] = $v['cigen'];
        }
        // halt($cigen_arr);
        $swt = db::query("select * from swt where  fwwz like '%utm_source=bd%'");
        // foreach ($swt as $k => $v) {
        //     $fwwz_utm = $this->getUtm($v['fwwz']);
        //     $arr[$k] = $v;
        //     $arr[$k]['utm'] = $fwwz_utm;
        // }
         $jinjia = db::query("select * from jinjia where pweb like '%utm_source=bd%' or mweb like '%utm_source=bd%'");
        foreach ($swt as $k => $v) {
            $fwwz_utm = $this->getUtm($v['fwwz']);
            $data[$k] = $v;
            $data[$k]['atime'] = $v['stime'];
            $data[$k]['stype'] = 'swt';
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

            foreach ($cigen_arr as $a => $b) {
                if (stripos($a, '*') !== false) {
                    $a_arr = explode('*', $a);
                    if (stripos($v['keyword'], $a_arr[0]) !== false && stripos($v['keyword'], $a_arr[1]) !== false) {
                        $data[$k]['cigen'] = $b;
                    }
                } else {
                    if (stripos($v['keyword'], $a) !== false) {
                        $data[$k]['cigen'] = $b;
                    }
                }
                if (!isset($data[$k]['cigen'])) {
                    $data[$k]['cigen'] = '其他';
                }
            }

            foreach($jinjia as $k=>$v){

                if (stripos($v['keyword'], $a) !== false) {
                    
                }
            }
        }
        halt($data);
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
