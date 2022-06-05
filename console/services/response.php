<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-05 10:25:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-05 10:47:46
 */
namespace console\services;

use yii\console\Response as ConsoleResponse;

class response extends ConsoleResponse
{
    public $cookies = [];
    public $statusCode;
}