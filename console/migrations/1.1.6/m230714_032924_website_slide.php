<?php

use yii\db\Migration;

class m230714_032924_website_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%website_slide}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'images' => "varchar(255) NULL",
            'title' => "varchar(255) NULL",
            'description' => "varchar(255) NULL",
            'menuname' => "varchar(255) NULL",
            'menuurl' => "varchar(255) NULL",
            'createtime' => "int(30) NULL",
            'updatetime' => "int(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%website_slide}}',['id'=>'6','images'=>'202201/19/f5ace6ab-879a-3ff2-a1e2-b96f0cbe0d08.jpg','title'=>'店滴CMS','description'=>'免费的多商户业务引擎','menuname'=>'免费下载','menuurl'=>'www','createtime'=>'1621220295','updatetime'=>'1645420532']);
        $this->insert('{{%website_slide}}',['id'=>'7','images'=>'http://www.ai.com/attachment/202105/17/9f46de01-7cf4-3507-a0a0-2791e3e55a73.jpg','title'=>'标题','description'=>'描述','menuname'=>'按钮名称','menuurl'=>'www','createtime'=>'1621220358','updatetime'=>'1621220358']);
        $this->insert('{{%website_slide}}',['id'=>'8','images'=>'http://www.ai.com/attachment/202105/17/9e70b63a-b679-3f91-913f-190c80854533.jpg','title'=>'标题','description'=>'描述','menuname'=>'按钮','menuurl'=>'www','createtime'=>'1621220480','updatetime'=>'1621220480']);
        $this->insert('{{%website_slide}}',['id'=>'11','images'=>'http://www.ai.com/attachment/202105/17/06c6fbe5-02c4-30bd-a9d5-0d5ea1d212ff.jpg','title'=>'新标题','description'=>'描述内容','menuname'=>'按钮名称','menuurl'=>'wwwwwww','createtime'=>'1621223009','updatetime'=>'1621223009']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%website_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

