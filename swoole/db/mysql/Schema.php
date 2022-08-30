<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 21:27:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-30 21:28:33
 */

namespace swooleService\db\mysql;

use swooleService\db\Connection;
use yii\di\Instance;

/**
 * Class Schema
 * @package swooleService\db\mysql
 */
class Schema extends \yii\db\mysql\Schema
{
    public $db = 'db';

    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }
}
