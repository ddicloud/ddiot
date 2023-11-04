<?php

use yii\db\Migration;

class m231104_123105_diandi_website_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_config}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(20) NOT NULL DEFAULT '' COMMENT '字段名英文'",
            'label' => "varchar(50) NOT NULL COMMENT '字段标注'",
            'value' => "varchar(3000) NOT NULL DEFAULT '' COMMENT '字段值'",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'language' => "varchar(20) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('u-language_name','{{%diandi_website_config}}','language, name',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

