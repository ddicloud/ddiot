<?php

use yii\db\Migration;

class m231104_123105_diandi_integral_spec_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_spec_value}}', [
            'spec_value_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'spec_value' => "varchar(255) NOT NULL",
            'spec_id' => "int(11) NOT NULL",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_value_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_spec_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

