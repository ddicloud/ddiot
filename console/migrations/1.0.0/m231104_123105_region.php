<?php

use yii\db\Migration;

class m231104_123105_region extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%region}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'pid' => "int(11) NULL",
            'shortname' => "varchar(100) NULL",
            'name' => "varchar(100) NULL",
            'merger_name' => "varchar(255) NULL",
            'level' => "tinyint(4) unsigned NULL DEFAULT '0'",
            'pinyin' => "varchar(100) NULL",
            'code' => "varchar(100) NULL",
            'zip_code' => "varchar(100) NULL",
            'first' => "varchar(50) NULL",
            'lng' => "varchar(100) NULL",
            'lat' => "varchar(100) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('name,level','{{%region}}','name, pid',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%region}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

