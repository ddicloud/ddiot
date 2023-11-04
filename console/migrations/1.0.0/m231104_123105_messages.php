<?php

use yii\db\Migration;

class m231104_123105_messages extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%messages}}', [
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
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%messages}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

