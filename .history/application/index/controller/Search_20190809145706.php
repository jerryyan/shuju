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
        $m_data = db::query("select *,a.keyword as ssword,b.keyword as tfword from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.mutm where  fwwz like '%utm_source=bdm%' GROUP BY a.id");
        $p_data = db::query("select *,a.keyword as ssword,b.keyword as tfword from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.putm where  fwwz like '%utm_source=bdp%' GROUP BY a.id");
        $list = array_merge($m_data, $p_data);
        foreach ($list as $k => $v) {
            $data[$k]['atime'] = $v['stime'];
            $data[$k]['stype'] = 'swt';
            $data[$k]['xiangmu'] = $v['xiangmu'];
            $data[$k]['zhanghu'] = $v['zhanghu'];
            $data[$k]['jihua'] = $v['jihua'];
            $data[$k]['dy'] = $v['dy'];
            source
            $data[$k]['tfword'] = $v['tfword'];
            $data[$k]['ssword'] = $v['ssword'];
            $data[$k]['zx'] = $v['zx'];
            $data[$k]['click'] = $v['click'];
            $data[$k]['zmxf'] = $v['zmxf'];
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
                    if (stripos($v['ssword'], $a_arr[0]) !== false && stripos($v['ssword'], $a_arr[1]) !== false) {
                        $data[$k]['cigen'] = $b;
                    }
                } else {
                    if (stripos($v['ssword'], $a) !== false) {
                        $data[$k]['cigen'] = $b;
                    }
                }
                if (!isset($data[$k]['cigen'])) {
                    $data[$k]['cigen'] = '其他';
                }
            }
        }
        // halt($data);
        // $res = Db::name('search_info')->insertAll($data);
        // if ($res) {
        //     return json(['code' => 1, 'msg' => '数据处理成功!']);
        // } else {
        //     return json(['code' => 0, 'msg' => '数据处理失败!']);
        // }
        return view();
    }


    public function show()
    {
        $list = db('search')->order('id', 'desc')->select();
        $this->assign('list', $list);
        return view();
    }

    public function filer(){
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
