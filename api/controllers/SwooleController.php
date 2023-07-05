<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-05 10:20:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 10:21:40
 */

namespace api\controllers;
 
use easyswoole\Http\Request;
use easyswoole\Http\Response;
use EasySwoole\Http\AbstractInterface\Controller;

class SwooleController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $response->write("Hello from EasySwoole!");
    }
}
