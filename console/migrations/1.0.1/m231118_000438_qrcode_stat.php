<?php

use yii\db\Migration;

class m231118_000438_qrcode_stat extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%qrcode_stat}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(10) unsigned NOT NULL",
            'bloc_id' => "int(10) unsigned NOT NULL",
            'qid' => "int(10) unsigned NOT NULL",
            'openid' => "varchar(50) NOT NULL",
            'type' => "tinyint(1) unsigned NOT NULL",
            'qrcid' => "bigint(20) unsigned NOT NULL",
            'scene_str' => "varchar(64) NOT NULL",
            'name' => "varchar(50) NOT NULL",
            'create_time' => "int(10) unsigned NOT NULL",
            'update_time' => "int(10) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%qrcode_stat}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

