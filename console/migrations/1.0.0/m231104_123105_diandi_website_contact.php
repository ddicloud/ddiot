<?php

use yii\db\Migration;

class m231104_123105_diandi_website_contact extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_contact}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(255) NULL COMMENT '公司名称'",
            'mobile' => "varchar(15) NULL COMMENT '联系电话'",
            'phone' => "varchar(15) NULL COMMENT '座机号码'",
            'email' => "varchar(50) NULL COMMENT '邮箱'",
            'address' => "varchar(255) NULL COMMENT '具体地址'",
            'intro' => "text NULL COMMENT '简介'",
            'logo' => "varchar(255) NULL COMMENT '公司logo'",
            'wechat_code' => "varchar(255) NULL COMMENT '公众号二维码'",
            'image' => "varchar(255) NULL COMMENT '配图'",
            'fax' => "varchar(255) NULL COMMENT '传真'",
            'postcode' => "varchar(255) NULL",
            'icp' => "varchar(255) NULL",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'createtime' => "varchar(30) NULL",
            'updatetime' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_contact}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

