<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-18 18:28:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-18 18:34:24
 */

namespace swooleService\pool;

use yii\base\BaseObject;

class RedisResultData extends BaseObject
{
    public $result = false;
    public $errCode = 0;
    public $errMsg = '';
}