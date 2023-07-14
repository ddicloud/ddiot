<?php

use yii\db\Migration;

class m230714_032924_queue extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%queue}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'channel' => "varchar(255) NOT NULL",
            'job' => "blob NOT NULL",
            'pushed_at' => "int(11) NOT NULL",
            'ttr' => "int(11) NOT NULL",
            'delay' => "int(11) NOT NULL DEFAULT '0'",
            'priority' => "int(11) unsigned NOT NULL DEFAULT '1024'",
            'reserved_at' => "int(11) NULL",
            'attempt' => "int(11) NULL",
            'done_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('channel','{{%queue}}','channel',0);
        $this->createIndex('reserved_at','{{%queue}}','reserved_at',0);
        $this->createIndex('priority','{{%queue}}','priority',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%queue}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

