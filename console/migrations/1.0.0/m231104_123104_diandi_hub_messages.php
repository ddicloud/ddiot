<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_messages extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_messages}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '企业ID'",
            'store_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '商户ID'",
            'category_id' => "int(11) NOT NULL COMMENT '分类ID'",
            'title' => "varchar(45) NOT NULL COMMENT '标题'",
            'content' => "text NOT NULL COMMENT '内容'",
            'admin_ids' => "varchar(450) NOT NULL DEFAULT '' COMMENT '接收者IDS'",
            'publish_at' => "varchar(20) NOT NULL COMMENT '发布时间'",
            'view' => "int(11) NOT NULL DEFAULT '0' COMMENT '查看次数'",
            'status' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='消息中心'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_messages}}',['id'=>'1','bloc_id'=>'31','store_id'=>'80','category_id'=>'1','title'=>'test1','content'=>'content','admin_ids'=>'','publish_at'=>'2022-10-10 14:38:30','view'=>'14','status'=>'1','created_at'=>'2022-10-10 14:39:58','updated_at'=>'2022-10-10 18:34:15']);
        $this->insert('{{%diandi_hub_messages}}',['id'=>'2','bloc_id'=>'31','store_id'=>'80','category_id'=>'1','title'=>'test','content'=>'content','admin_ids'=>'1','publish_at'=>'2022-10-10 14:38:30','view'=>'1','status'=>'1','created_at'=>'2022-10-10 14:43:27','updated_at'=>'2022-10-10 14:43:27']);
        $this->insert('{{%diandi_hub_messages}}',['id'=>'3','bloc_id'=>'31','store_id'=>'80','category_id'=>'1','title'=>'test','content'=>'content','admin_ids'=>'1,9,10,11,31','publish_at'=>'2022-10-10 14:38:30','view'=>'1','status'=>'1','created_at'=>'2022-10-10 14:43:53','updated_at'=>'2022-10-10 14:43:53']);
        $this->insert('{{%diandi_hub_messages}}',['id'=>'4','bloc_id'=>'35','store_id'=>'86','category_id'=>'2','title'=>'消息','content'=>'消息消息消息消息消息消息消息消息消息消息消息','admin_ids'=>'11','publish_at'=>'2022-11-07 14:41:38','view'=>'1','status'=>'1','created_at'=>'2022-11-07 14:41:46','updated_at'=>'2022-11-07 14:42:46']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_messages}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

