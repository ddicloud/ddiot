<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-25 12:30:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 11:33:43
 */

namespace console\controllers;

use common\helpers\loggingHelper;
use diandi\swoole\timer\Timer;
use yii\console\Controller;

// use EasySwoole\Core\Http\AbstractInterface\Controller;

class WorkerController extends Controller
{
    // public function actionListen($queueName='default',$attempt=10,$memeory=128,$sleep=3 ,$delay=0){
    //     Worker::listen(\Yii::$App->queue,$queueName,$attempt,$memeory,$sleep,$delay);
    // }

    public function index()
    {
        $this->response()->write("Hello from EasySwoole!");
    }
}
