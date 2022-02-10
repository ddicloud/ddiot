<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 12:49:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-14 14:00:45
 */

namespace console\controllers;

use common\services\backend\NavService;
use Yii;
use yii\console\Controller;

// 使用示例： ./yii addons -addons=diandi_lottery -bloc_id=1 -store_id=3   job ninini

class ChmodController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $baseDir = dirname(__FILE__) . '/../../';

        $dirs = ["api/runtime/", "backend/assets/", "backend/runtime/", "frontend/runtime/", "frontend/web/assets/", "frontend/web/backend/assets", "frontend/web/attachment", "console/swoole/runtime/", "admin/runtime/"];

        foreach ($dirs as $key => $value) {
            if (is_dir($baseDir . $value)) {
                chmod($baseDir . $value, 0777);
            } else {
                mkdir($baseDir . $value, 0777);
                chmod($baseDir . $value, 0777);
            }
            echo "目录" . $value . '权限设置成功' . PHP_EOL;
            sleep(1);
        }
    }
}
