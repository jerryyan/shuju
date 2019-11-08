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
        $swt = db::query("select * from swt where source in ('KWD','PFT') ");
        foreach($swt as ){
            $arr=$this->convertUrlQuery($swt);
        }
       
        $jinjia = db::query("select * from jinjia where xiangmu='远大肛肠'");

        // halt($swt);
    }
    
    /**
     * 解析url中参数信息，返回参数数组
     */
    public function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }
}
