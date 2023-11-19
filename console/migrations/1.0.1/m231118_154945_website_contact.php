<?php

use yii\db\Migration;

class m231118_154945_website_contact extends Migration
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
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%website_contact}}',['id'=>'1','name'=>'21','feedback'=>'4545','contact'=>'34','createtime'=>'1662719856','updatetime'=>'1662719856']);
        $this->insert('{{%website_contact}}',['id'=>'2','name'=>'v','feedback'=>'演示页面无法访问','contact'=>'17720757182','createtime'=>'1696818710','updatetime'=>'1696818710']);
        $this->insert('{{%website_contact}}',['id'=>'3','name'=>'李彪','feedback'=>'硬件产品价格表','contact'=>'13941832188','createtime'=>'1698058283','updatetime'=>'1698058283']);
        
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

