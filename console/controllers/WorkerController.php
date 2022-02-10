<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-25 12:30:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-17 12:10:32
 */
 
namespace console\controllers;

use common\helpers\loggingHelper;
use diandi\swoole\timer\Timer;

class WorkerController extends BaseController
{
    // public function actionListen($queueName='default',$attempt=10,$memeory=128,$sleep=3 ,$delay=0){
    //     Worker::listen(\Yii::$app->queue,$queueName,$attempt,$memeory,$sleep,$delay);
    // }

    public function actionTimer()
    {
        Timer::tick(1000,function($cb,$jobId,$coroutineID)
        {
            loggingHelper::writeLog('diandi_im', 'timer', '定时任务测试',[$cb,$jobId,$coroutineID]); 
            
        },'12458');
        
    }
}