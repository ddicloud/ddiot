<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-08 16:01:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-08 16:17:09
 */
namespace ddswoole\db\mysql;

use common\helpers\ArrayHelper;

/**
 * 兼容不同版本的fetchAll
 */

if (version_compare(PHP_VERSION, '8.0', '>')) {
    trait fetchAll{
        #[\ReturnTypeWillChange]
        public function  fetchAll(int $fetch_style = \PDO::FETCH_DEFAULT, mixed ...$args): array
        {
            if (empty($this->data)) {
                return [];
            }
            if ($fetch_style == \PDO::FETCH_COLUMN) {
                $key = key($this->data[0]);
    
                return ArrayHelper::getColumn($this->data, $key);
            }
    
            return $this->data;
        }
    }
}else{  
    trait fetchAll{
        
        #[\ReturnTypeWillChange]
        public function fetchAll($fetch_style = \PDO::FETCH_COLUMN, $class_name = null, $ctor_args = null): array
        {
            if (empty($this->data)) {
                return [];
            }
            if ($fetch_style == \PDO::FETCH_COLUMN) {
                $key = key($this->data[0]);

                return ArrayHelper::getColumn($this->data, $key);
            }

            return $this->data;
        }
    }

}

?>