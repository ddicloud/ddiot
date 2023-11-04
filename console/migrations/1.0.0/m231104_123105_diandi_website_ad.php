<?php

use yii\db\Migration;

class m231104_123105_diandi_website_ad extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_ad}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'title' => "varchar(50) NOT NULL DEFAULT ''",
            'type' => "tinyint(4) NULL DEFAULT '101' COMMENT '1 轮播图 2 友情链接'",
            'category_id' => "int(11) NULL DEFAULT '0'",
            'image' => "varchar(255) NOT NULL DEFAULT ''",
            'link' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NOT NULL DEFAULT '0'",
            'updated_at' => "int(11) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('i-type-category','{{%diandi_website_ad}}','type, category_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_ad}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

