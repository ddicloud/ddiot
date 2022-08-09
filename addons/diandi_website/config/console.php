<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 14:51:30
 */


return [
    'controllerMap' => [
        'cron' => [
            'class' => 'addons\diandi_task\console\swoole\CronController', //生成 php ./yii cron/action
        ]
    ]
];
