<?php

use yii\db\Migration;

class m221018_095111_diandi_hub_messages_read extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_messages_read}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'admin_id' => "int(11) NOT NULL COMMENT '管理员ID'",
            'message_id' => "int(11) NOT NULL COMMENT '消息ID'",
            'created_at' => "datetime NOT NULL COMMENT '阅读时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='阅读记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_messages_read}}',['id'=>'1','admin_id'=>'31','message_id'=>'1','created_at'=>'2022-10-11 11:49:10']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_messages_read}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

