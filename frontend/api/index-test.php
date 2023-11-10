<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 20:27:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 14:50:10
 */

use yii\base\InvalidConfigException;


defined('YII_ENV_DEV') or define('YII_ENV_DEV', true);
//生产环境prod的入口文件代码
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../../api/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../../api/config/main.php',
    require __DIR__ . '/../../api/config/main-local.php'
);

/**
 * 打印.
 */
function p(...$array): void
{
    echo '<pre>';

    if (count($array) == 1) {
        print_r($array[0]);
    } else {
        print_r($array);
    }

    echo '</pre>';
}

try {
    (new yii\web\Application($config))->run();
} catch (InvalidConfigException $e) {
    throw new \yii\base\ErrorException($e->getMessage(),400);
}
