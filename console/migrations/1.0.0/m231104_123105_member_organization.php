<?php

use yii\db\Migration;

class m231104_123105_member_organization extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member_organization}}', [
            'group_id' => "int(11) NOT NULL AUTO_INCREMENT",
            'item_name' => "varchar(64) NOT NULL COMMENT '名称'",
            'intro' => "varchar(255) NULL COMMENT '组织机构'",
            'group_pid' => "int(11) NULL DEFAULT '0' COMMENT '父级组织'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`group_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公司会员组织结构（内部系统使用）'");
        
        /* 索引设置 */
        $this->createIndex('item_name','{{%member_organization}}','item_name',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member_organization}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

