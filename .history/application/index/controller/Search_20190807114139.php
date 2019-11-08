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

        // foreach ($search as $k => $v) {
        //     $arr[$v['xiangmu']][$v['cigen']][] = $v['guize'];
        // }
        // halt($arr);
        $swt = db::query("select * from swt where  fwwz like '%utm_source=bd%' and  source in ('KWD','PFT') and id >=61332");
        // halt($swt);
        foreach ($swt as $k => $v) {
            $fwwz_utm = $this->getUtm($v['fwwz']);
            echo '<pre>';
            echo ($v['id'] . '->' . $fwwz_utm);
            // $swt_data[$k]=$v;
            // $swt_data[$k]['utm']=$fwwz_utm;
            // halt($v['id'].'->'.$fwwz_utm);
            //$jinjia = db::query("select * from jinjia where (mweb like '%$fwwz_utm%' ) and xiangmu='远大肛肠'");
        }
        halt($v['id'] . '->' . $fwwz_utm);

        //$jinjia = db::query("select * from jinjia where xiangmu='远大肛肠'");
        // return view();
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
        if (stripos($url, 'utm_source')) {
           // $url = str_replace("?&", "?", $url);
           // $arr = parse_url($url);           
             $queryParts = explode('utm_source=', $url);
            $res= explode('&', $queryParts);
            $str=$res[0].'&'.

    }


}
