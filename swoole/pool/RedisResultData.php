<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 10:12:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 10:13:13
 */

namespace ddswoole\pool;

use yii\base\BaseObject;

class RedisResultData extends BaseObject
{
    public $result = false;
    public $errCode = 0;
    public $errMsg = '';
}
