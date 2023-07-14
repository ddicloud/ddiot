<?php

use yii\db\Migration;

class m230714_032924_messages_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%messages_category}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '企业ID'",
            'store_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '商户ID'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '上级分类'",
            'name' => "varchar(45) NOT NULL COMMENT '分类名称'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='消息分类'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%messages_category}}',['id'=>'1','bloc_id'=>'31','store_id'=>'80','pid'=>'0','name'=>'test1','created_at'=>'2022-10-09 17:50:49','updated_at'=>'2022-10-09 18:01:28']);
        $this->insert('{{%messages_category}}',['id'=>'2','bloc_id'=>'35','store_id'=>'86','pid'=>'0','name'=>'分类1','created_at'=>'2022-11-07 14:41:15','updated_at'=>'2022-11-07 14:41:15']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%messages_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

