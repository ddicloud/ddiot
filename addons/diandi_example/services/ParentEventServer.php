<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-22 22:11:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-23 10:56:02
 */

namespace addons\diandi_example\services;

use common\services\BaseService;
use Yii;

class ParentEventServer extends BaseService
{
    const EVENT_LOCK_OPEN = 'foo.method_is_not_found';

    public function ceshi($params)
    {
        echo '父级第一个输出';
       

        return ['data' => $params];
    }
}
