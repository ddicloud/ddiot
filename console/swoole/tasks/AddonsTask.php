<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:38:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-23 19:14:50
 */

namespace swooleService\tasks;

use Yii;

class AddonsTask
{
    public function createAddons($addons, $action,$param)
    {   
        $param['__class'] = 'CeshiController';
        Yii::$app->getModule($addons)->$action($param);
        printf("a:%s b:%s\n", $addons, $action);
        return 'ok';
    }
}