<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:23:55
 */

namespace common\components\oss\events;

use yii\base\Event;

/**
 * StorageEvent 事件
 *
 */
class StorageEvent extends Event
{

    public $filesystem;

    /**
     * @var string 路径
     */
    public $path;
}
