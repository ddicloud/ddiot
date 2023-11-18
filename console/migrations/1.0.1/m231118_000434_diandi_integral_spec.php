<?php

use yii\db\Migration;

class m231118_000434_diandi_integral_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_spec}}', [
            'spec_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'spec_name' => "varchar(255) NOT NULL DEFAULT ''",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

