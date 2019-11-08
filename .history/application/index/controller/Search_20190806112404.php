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
        utm
        $jinjia = db::query("select * from jinjia where xiangmu='远大肛肠'");
     
       // halt($swt);
    }
}
