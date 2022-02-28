<?php

use yii\db\Migration;

class m220228_021727_auth_assignment_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_assignment_group}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'group_id' => "int(11) NOT NULL",
            'item_id' => "int(11) NULL",
            'item_name' => "varchar(64) NOT NULL",
            'user_id' => "varchar(64) NOT NULL",
            'created_at' => "int(11) NULL",
            'PRIMARY KEY (`id`,`item_name`,`user_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户权限组'");
        
        /* 索引设置 */
        $this->createIndex('auth_assignment_user_id_idx','{{%auth_assignment_group}}','user_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_assignment_group}}',['id'=>'1','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'1','created_at'=>'1588768586']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'2','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'14','created_at'=>'1588816083']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'3','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'15','created_at'=>'1592303323']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'4','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'19','created_at'=>'1592302886']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'5','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'2','created_at'=>'1588756893']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'6','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'31','created_at'=>'1632977957']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'7','group_id'=>'551','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'32','created_at'=>'1636555874']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'11','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'1','created_at'=>'1588768586']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'12','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'11','created_at'=>'1589288348']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'13','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'31','created_at'=>'1632977952']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'14','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'32','created_at'=>'1636555874']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'15','group_id'=>'60','item_id'=>'60','item_name'=>'总管理员','user_id'=>'11','created_at'=>'1644385823']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'16','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'33','created_at'=>'1644503100']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'17','group_id'=>'60','item_id'=>'60','item_name'=>'总管理员','user_id'=>'33','created_at'=>'1644505419']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_assignment_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

