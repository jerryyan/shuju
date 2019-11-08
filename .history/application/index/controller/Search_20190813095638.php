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
        $a_sql = 'SELECT cigen,sum(click) as aclick,sum(zx) as azx,round(sum(zmxf),2) as azmxf,SUM(fanwwen) as afw,SUM(duihua) as adh,SUM(youxiao) as ayx,SUM(liulian) as aliulian FROM search_info  GROUP BY cigen ORDER BY azmxf  DESC';
        $all_list = db::query($a_sql);
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
            self::
            $data[$k]['djl'] =self::getRound($v['aclick'], $v['azx'], 1);
            $data[$k]['ddl'] = $this->getRound($v['afw'],  $v['aclick'], 1);
            $data[$k]['yxzb'] = $this->getRound($v['ayx'], $v['adh'], 1);
            $data[$k]['llv'] = $this->getRound($v['aliulian'], $v['adh'], 1);
            $data[$k]['djcb'] = $this->getRound($v['azmxf'], $v['aclick']);
            $data[$k]['dhcb'] = $this->getRound($v['azmxf'], $v['adh']);
            $data[$k]['yxcb'] = $this->getRound($v['azmxf'], $v['ayx']);
            $data[$k]['llxb'] = $this->getRound($v['azmxf'], $v['aliulian']);
        }
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
        $new_list = json_encode($data);
        $this->assign('list', $new_list);
        // echo $new_list;
        return view();
    }


    public function info()
    {

        // return json_encode($list);

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
