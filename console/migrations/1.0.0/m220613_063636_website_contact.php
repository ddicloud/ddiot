<?php

use yii\db\Migration;

class m220613_063636_website_contact extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%website_contact}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(255) NULL",
            'feedback' => "varchar(255) NULL",
            'contact' => "varchar(255) NULL",
            'createtime' => "varchar(30) NULL",
            'updatetime' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%website_contact}}',['id'=>'1','name'=>'','feedback'=>'sssssssssssssssssss','contact'=>'1968289446@qq.com','createtime'=>'1649750094','updatetime'=>'1649750094']);
        $this->insert('{{%website_contact}}',['id'=>'2','name'=>'','feedback'=>'sssssssssssssssssss','contact'=>'1968289446@qq.com','createtime'=>'1649750108','updatetime'=>'1649750108']);
        $this->insert('{{%website_contact}}',['id'=>'3','name'=>'','feedback'=>'11111111111111111111111111111','contact'=>'1111111111@qq.com','createtime'=>'1652061048','updatetime'=>'1652061048']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%website_contact}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

