<?php

namespace app\index\controller;

use think\Db;
use think\Controller;
use think\Request;
use think\exception\DbException;

class Index extends Controller
{
    public function index()
    {
        return view();
    }

    