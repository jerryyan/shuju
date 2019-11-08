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
        ini_set('memory_limit', '3072M');    // 临时设置最大内存占用为3G
        set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过期
        $search = db('search')->order('id', 'desc')->select();

        foreach ($search as $k => $v) {
            $cigen_arr[$v['guize']] = $v['cigen'];
        }
        $m_data = db::query("select * from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.mutm where  fwwz like '%utm_source=bdm%' GROUP BY a.id");
        $p_data = db::query("select * from swt as a  LEFT  JOIN  jinjia as b ON a.utm=b.putm where  fwwz like '%utm_source=bdp%' GROUP BY a.id");
        array_merge()

        foreach ($swt as $k => $v) {
            $fwwz_utm = $this->getUtm($v['fwwz']);
;
            $data[$k]['atime'] = $v['stime'];
            $data[$k]['stype'] = 'swt';
            $data[$k]['fanwwen'] = 1;
            $data[$k]['ssword'] = $v['keyword'];
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
            //过滤数组
            // $items = array_filter($jinjia, function ($v) use ($fwwz_utm) {
            //     return stripos($v['pweb'], $fwwz_utm) !== false || stripos($v['mweb'], $fwwz_utm) !== false;
            // });
            // //取数组第一个元素
            // $items = array_shift($items);
            // if (count($items) > 0) {
            //     $data[$k]['zhanghu'] = $items['zhanghu'];
            //     $data[$k]['jihua'] = $items['jihua'];
            //     $data[$k]['dy'] = $items['dy'];
            //     $data[$k]['tfword'] = $items['keyword'];
            // }
        }
        //  halt($data);
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
