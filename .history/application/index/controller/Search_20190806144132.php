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
        $swt = db::query("select * from swt where source in ('KWD','PFT') and id>=61151");
        // halt($swt);
        foreach ($swt as $k => $v) {
            $utm = $this->getUtm($v['fwwz']);
            var_dump($v['id'] . '->' . $utm);
        }

        $jinjia = db::query("select * from jinjia where xiangmu='远大肛肠'");
    }

    /**
     * 解析url中参数信息，返回参数数组
     */
    public function getUtm($url)
    {
        if (stripos($url, 'utm_source')) {
            $url = str_replace("?&", "?", $url);
            $arr = parse_url($url);
            $queryParts = explode('&', $arr['query']);
            $params = array();
            foreach ($queryParts as $param) {
                $item = explode('=', $param);
                $params[$item[0]] = $item[1];
            }

            return $params['utm_source'];
        } else {
            return '';
        }
    }


    function getUrlParam($cparam, $url = ''){
        $parse_url = $url === '' ? parse_url($_SERVER["REQUEST_URI"]) : parse_url($url);
        $query = isset($parse_url['query']) ? $parse_url['query'] : '';
        $params = parseUrlParam($query);
        return isset($params[$cparam]) ? $params[$cparam] : '';
    }
}
