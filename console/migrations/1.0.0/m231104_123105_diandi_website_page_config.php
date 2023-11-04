<?php

use yii\db\Migration;

class m231104_123105_diandi_website_page_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_page_config}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'title' => "varchar(30) NOT NULL",
            'template' => "varchar(50) NULL DEFAULT '0'",
            'type' => "varchar(15) NOT NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%diandi_website_page_config}}','type',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_page_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

