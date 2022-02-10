<?php

use yii\db\Migration;

class m211229_023907_qrcode extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%qrcode}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(10) unsigned NOT NULL",
            'bloc_id' => "int(11) NULL",
            'member_id' => "int(11) NULL",
            'type' => "varchar(10) NOT NULL",
            'extra' => "int(10) unsigned NOT NULL",
            'qrcid' => "bigint(20) NOT NULL",
            'scene_str' => "varchar(64) NOT NULL",
            'name' => "varchar(50) NOT NULL",
            'keyword' => "varchar(100) NOT NULL",
            'model' => "tinyint(1) unsigned NOT NULL",
            'ticket' => "varchar(250) NOT NULL",
            'url' => "varchar(256) NOT NULL",
            'expire' => "int(10) unsigned NOT NULL",
            'subnum' => "int(10) unsigned NOT NULL",
            'update_time' => "int(10) NULL",
            'create_time' => "int(10) unsigned NOT NULL",
            'status' => "tinyint(1) unsigned NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('idx_qrcid','{{%qrcode}}','qrcid',0);
        $this->createIndex('uniacid','{{%qrcode}}','store_id',0);
        $this->createIndex('ticket','{{%qrcode}}','ticket',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%qrcode}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

