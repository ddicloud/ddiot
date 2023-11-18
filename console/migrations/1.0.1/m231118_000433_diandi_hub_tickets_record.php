<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_tickets_record extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_tickets_record}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'tickets_id' => "int(11) NOT NULL COMMENT '工单ID'",
            'send_id' => "int(11) NOT NULL COMMENT '发送方ID'",
            'type' => "tinyint(2) NOT NULL COMMENT '消息发送类型（用户发送|开发者发送）'",
            'content' => "varchar(900) NOT NULL COMMENT '内容'",
            'created_at' => "datetime NOT NULL COMMENT '创建日期'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='工单沟通记录'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'1','tickets_id'=>'1','send_id'=>'1004','type'=>'1','content'=>'test','created_at'=>'2022-09-22 16:58:32']);
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'2','tickets_id'=>'1','send_id'=>'1004','type'=>'1','content'=>'驱蚊器翁','created_at'=>'2022-09-22 17:56:16']);
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'3','tickets_id'=>'1','send_id'=>'1004','type'=>'1','content'=>'驱蚊器翁','created_at'=>'2022-09-22 17:56:56']);
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'4','tickets_id'=>'1','send_id'=>'1004','type'=>'1','content'=>'驱蚊器翁','created_at'=>'2022-09-22 17:57:01']);
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'5','tickets_id'=>'1','send_id'=>'31','type'=>'2','content'=>'test','created_at'=>'2022-09-23 17:36:42']);
        $this->insert('{{%diandi_hub_tickets_record}}',['id'=>'6','tickets_id'=>'1','send_id'=>'31','type'=>'2','content'=>'test','created_at'=>'2022-09-23 17:37:38']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_tickets_record}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

