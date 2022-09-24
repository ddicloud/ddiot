<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 11:59:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 12:00:06
 */

namespace ddswoole\cache\session;

use Yii;

/**
 * Class Session.
 */
class Session extends \yii\web\Session
{
    use SessionTrait;

    public function init()
    {
        parent::init();
//        register_shutdown_function([$this, 'close']);
        if ($this->getIsActive()) {
            Yii::warning('Session is already started in swoole', __METHOD__);
            $this->updateFlashCounters();
        }
    }
}
