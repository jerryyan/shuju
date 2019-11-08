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
        $jinjia=db::query("select * from jinjia where xiangmu='远大肛肠'");
       
    }

}