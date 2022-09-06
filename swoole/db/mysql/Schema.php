<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 21:27:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-06 15:44:20
 */

namespace ddswoole\db\mysql;

use ddswoole\db\Connection;
use yii\di\Instance;

/**
 * Class Schema
 * @package ddswoole\db\mysql
 */ 
class Schema extends \yii\db\mysql\Schema
{
    public $db = 'db';

    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }
    
    // public function getTableSchema($name,$ref=false){
           
    // }
}
