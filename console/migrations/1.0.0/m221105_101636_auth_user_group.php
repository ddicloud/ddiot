<?php

use yii\db\Migration;

class m221105_101636_auth_user_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_user_group}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'item_id' => "int(11) NULL",
            'name' => "varchar(64) NOT NULL COMMENT '用户组名称'",
            'is_sys' => "smallint(6) NULL COMMENT '0否1是'",
            'description' => "text NULL COMMENT '用户组名称'",
            'bloc_id' => "int(11) NULL COMMENT '公司'",
            'store_id' => "int(11) NULL COMMENT '商户'",
            'is_default' => "int(11) NULL DEFAULT '0' COMMENT '是否默认'",
            'created_at' => "int(11) NULL",
            'updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`,`name`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台用户组'");
        
        /* 索引设置 */
        $this->createIndex('name','{{%auth_user_group}}','name',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_user_group}}',['id'=>'551','item_id'=>'59','name'=>'基础权限组','is_sys'=>'1','description'=>'','bloc_id'=>'0','store_id'=>'0','is_default'=>'0','created_at'=>'1588976797','updated_at'=>'1588837647']);
        $this->insert('{{%auth_user_group}}',['id'=>'552','item_id'=>'60','name'=>'总管理员','is_sys'=>'1','description'=>'','bloc_id'=>'0','store_id'=>'0','is_default'=>'0','created_at'=>'1588976797','updated_at'=>'1621841609']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_user_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

