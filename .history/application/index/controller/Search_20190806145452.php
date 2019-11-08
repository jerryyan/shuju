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
            $dhly_utm = $this->getUtm($v['dhly']);
            $fyly_utm = $this->getUtm($v['fyly']);
            $fwwz_utm = $this->getUtm($v['fwwz']);
            if ($dhly_utm != $fyly_utm || $fyly_utm != $fwwz_utm || $dhly_utm !=  $fwwz_utm) {
                echo '<pre>';
                echo $dhly_utm . '->' . $fyly_utm . '->' . $fwwz_utm;
            }
        }

        $jinjia = db::query("select * from jinjia where xiangmu='远大肛肠'");
    }

    public function searchMa(){
            return view();
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
                if (stripos($param, '=')) {
                    $item = explode('=', $param);
                    $params[$item[0]] = $item[1];
                }
            }
            return $params['utm_source'];
        } else {
            return '';
        }
    }
}
