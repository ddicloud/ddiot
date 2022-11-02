<?php

use yii\db\Migration;

class m221102_024926_auth_assignment_group extends Migration
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
        $this->insert('{{%auth_assignment_group}}',['id'=>'11','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'1','created_at'=>'1588768586']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'12','group_id'=>'552','item_id'=>'60','item_name'=>'总管理员','user_id'=>'11','created_at'=>'1589288348']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'21','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'17','created_at'=>'1659088795']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'23','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'18','created_at'=>'1659089322']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'27','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'45','created_at'=>'1666063819']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'28','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'46','created_at'=>'1666063878']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'29','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'47','created_at'=>'1666063910']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'30','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'48','created_at'=>'1666316691']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'31','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'49','created_at'=>'1666419303']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'32','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'50','created_at'=>'1666674282']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'33','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'51','created_at'=>'1666776697']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'34','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'53','created_at'=>'1666783081']);
        $this->insert('{{%auth_assignment_group}}',['id'=>'40','group_id'=>'59','item_id'=>'59','item_name'=>'基础权限组','user_id'=>'59','created_at'=>'1666839823']);
        
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

