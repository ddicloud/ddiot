<?php

use yii\db\Migration;

class m221102_024927_auth_user_group extends Migration
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
        $this->insert('{{%auth_user_group}}',['id'=>'555','item_id'=>'14398','name'=>'测试112','is_sys'=>'0','description'=>'测试12','bloc_id'=>'0','store_id'=>'65','is_default'=>'1','created_at'=>'1666749783','updated_at'=>'1666773394']);
        $this->insert('{{%auth_user_group}}',['id'=>'556','item_id'=>'15092','name'=>'测试112312','is_sys'=>'1','description'=>'12','bloc_id'=>'0','store_id'=>'64','is_default'=>'1','created_at'=>'1666949028','updated_at'=>'1666949028']);
        $this->insert('{{%auth_user_group}}',['id'=>'557','item_id'=>'15093','name'=>'手表002','is_sys'=>'1','description'=>'23','bloc_id'=>'0','store_id'=>'65','is_default'=>'1','created_at'=>'1666949146','updated_at'=>'1666949146']);
        $this->insert('{{%auth_user_group}}',['id'=>'558','item_id'=>'15094','name'=>'232','is_sys'=>'1','description'=>'34','bloc_id'=>'0','store_id'=>'64','is_default'=>'1','created_at'=>'1666949843','updated_at'=>'1666949843']);
        $this->insert('{{%auth_user_group}}',['id'=>'559','item_id'=>'15095','name'=>'6要75','is_sys'=>'1','description'=>'657','bloc_id'=>'28','store_id'=>'78','is_default'=>'1','created_at'=>'1666953302','updated_at'=>'1666953302']);
        $this->insert('{{%auth_user_group}}',['id'=>'560','item_id'=>'15096','name'=>'好的','is_sys'=>'0','description'=>'34','bloc_id'=>'0','store_id'=>'0','is_default'=>'1','created_at'=>'1666953866','updated_at'=>'1666953866']);
        $this->insert('{{%auth_user_group}}',['id'=>'561','item_id'=>'15097','name'=>'智能智能','is_sys'=>'0','description'=>'23232','bloc_id'=>'13','store_id'=>'64','is_default'=>'0','created_at'=>'1666954013','updated_at'=>'1666954013']);
        $this->insert('{{%auth_user_group}}',['id'=>'562','item_id'=>'15098','name'=>'23232','is_sys'=>'0','description'=>'23','bloc_id'=>'8','store_id'=>'61','is_default'=>'1','created_at'=>'1666954075','updated_at'=>'1666954075']);
        
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

