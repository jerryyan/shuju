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
        $sql = 'SELECT cigen,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayd,SUM(liulian) as aliulian FROM search_info  GROUP BY cigen';
        $all_list = db::query($sql);
        foreach ($all_list as $k => $v) {
            $data[$k]['id'] = $v['cigen'];
            $data[$k]['pid'] = 0;
            $data[$k]['title'] = $v['cigen'];
            $data[$k]['xf'] = $v['azmxf'];
            $data[$k]['zx'] = $v['azx'];
            $data[$k]['click'] = $v['aclick'];
            $data[$k]['fanwen'] = $v['afw'];
            $data[$k]['duihua'] = $v['adh'];
            $data[$k]['youxiao'] = $v['ayd'];
            $data[$k]['liulian'] = $v['aliulian'];
            $data[$k]['djl'] = $this->getRound($v['aclick'], $v['azx']);
            $data[$k]['ddl'] = $this->getRound($v['aclick'], $v['azx']);
            $data[$k]['yxzb'] =$this->getRound($v['aclick'], $v['azx']);
            $data[$k]['llv'] =$this->getRound($v['aclick'], $v['azx']);
            $data[$k]['djcb'] = $v['cigen'];
            $data[$k]['dhcb'] = $v['cigen'];
            $data[$k]['yxcb'] = $v['cigen'];
            $data[$k]['llxb'] = $v['cigen'];
        }
        $list = db('search_info')->order('id', 'desc')->select();

        $sum = 0;

        halt($data);
        return view();
    }
    public function getRound($a, $b)
    {
        $c = round($a / $b * 100,1) . "％";
        return $c;
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
