<?php

use yii\db\Migration;

class m231118_154945_diandi_website_link extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_link}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(255) NULL COMMENT '公司名称'",
            'intro' => "text NULL COMMENT '简介'",
            'logo' => "varchar(255) NULL COMMENT '公司logo'",
            'wechat_code' => "varchar(255) NULL COMMENT '公众号二维码'",
            'image' => "varchar(255) NULL COMMENT '显示图片'",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
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
        $this->dropTable('{{%diandi_website_link}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

