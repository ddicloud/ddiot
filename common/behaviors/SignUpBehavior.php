<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-12 13:47:35
 */

namespace common\behaviors;

use common\helpers\loggingHelper;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Skilly
 */
class SignUpBehavior extends Behavior
{
    public function init()
    {
        global $_GPC;
    }

    //@see http://www.yiichina.com/doc/api/2.0/yii-base-behavior#events()-detail
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ];
    }

    public function afterInsert($event)
    {
        loggingHelper::writeLog('SignUpBehavior', 'SignUpBehavior', '会员存储行为', [
            'attributes' => $this->attributes,
            'owner' => $this->owner,
            'event' => $event,
        ]);
    }
}
