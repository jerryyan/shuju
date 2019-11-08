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
        $jinjia=db('jinjia')::query("select * from think_user where status=1");
    }

}