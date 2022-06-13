<?php

use yii\db\Migration;

class m220613_055820_bloc_conf_app extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_app}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'android_ver' => "varchar(255) NULL",
            'android_url' => "varchar(255) NULL",
            'ios_ver' => "varchar(255) NULL",
            'ios_url' => "varchar(255) NULL",
            'partner' => "varchar(255) NULL",
            'partner_key' => "varchar(255) NULL",
            'paysignkey' => "varchar(255) NULL",
            'app_id' => "varchar(255) NULL",
            'app_secret' => "varchar(255) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_conf_app}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

