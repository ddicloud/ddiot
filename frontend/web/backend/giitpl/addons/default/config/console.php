<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-24 20:01:05
 */
echo "<?php\n";
?>

return [
    'controllerMap' => [
        'cron' => [
            'class' => 'addons\diandi_task\console\swoole\CronController',//生成 php ./yii cron/action
        ]
    ]
]; 