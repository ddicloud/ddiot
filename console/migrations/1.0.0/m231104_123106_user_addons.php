<?php

use yii\db\Migration;

class m231104_123106_user_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_addons}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '默认商户'",
            'type' => "smallint(6) NULL COMMENT '用户类型'",
            'module_name' => "varchar(50) NULL COMMENT '所属模块'",
            'user_id' => "int(11) NULL COMMENT '用户id'",
            'is_default' => "int(11) NULL DEFAULT '0' COMMENT '是否默认'",
            'status' => "smallint(6) NULL COMMENT '审核状态'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='扩展模块用户表'");
        
        /* 索引设置 */
        $this->createIndex('module_name','{{%user_addons}}','module_name',0);
        $this->createIndex('user_id','{{%user_addons}}','user_id',0);
        

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_addons}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

