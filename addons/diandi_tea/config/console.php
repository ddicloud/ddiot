<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-15 16:00:30
 */


return [
    'controllerMap' => [
        'cron' => [
            'class' => 'addons\diandi_task\console\swoole\CronController',//生成 php ./yii cron/action
        ]
    ]
]; 