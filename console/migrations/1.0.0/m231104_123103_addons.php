<?php

use yii\db\Migration;

class m231104_123103_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addons}}', [
            'mid' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模块id'",
            'is_nav' => "int(11) NULL COMMENT '是否导航'",
            'identifie' => "varchar(100) NOT NULL COMMENT '英文标识'",
            'type' => "varchar(30) NULL DEFAULT 'base' COMMENT '模块类型'",
            'title' => "varchar(100) NOT NULL COMMENT '名称'",
            'version' => "varchar(15) NOT NULL COMMENT '版本'",
            'ability' => "varchar(500) NOT NULL COMMENT '简介'",
            'description' => "varchar(1000) NOT NULL COMMENT '描述'",
            'author' => "varchar(50) NOT NULL COMMENT '作者'",
            'url' => "varchar(255) NOT NULL COMMENT '社区地址'",
            'settings' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '配置'",
            'logo' => "varchar(250) NOT NULL COMMENT 'logo'",
            'versions' => "varchar(50) NULL COMMENT '适应的软件版本'",
            'is_install' => "tinyint(1) NULL",
            'parent_mids' => "varchar(250) NULL DEFAULT '0'",
            'PRIMARY KEY (`mid`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='扩展模块表'");
        
        /* 索引设置 */
        $this->createIndex('idx_name','{{%addons}}','identifie',0);
        
        
        /* 表数据 */
        $this->insert('{{%addons}}',['mid'=>'204','is_nav'=>NULL,'identifie'=>'diandi_integral','type'=>'base','title'=>'积分','version'=>'1.0.0','ability'=>'1','description'=>'','author'=>'','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'201']);
        $this->insert('{{%addons}}',['mid'=>'210','is_nav'=>NULL,'identifie'=>'diandi_mall','type'=>'buss','title'=>'商城','version'=>'1.0.0','ability'=>'1','description'=>'多商户商城','author'=>'wanchunsheng','url'=>'www.baidu.com','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0']);
        $this->insert('{{%addons}}',['mid'=>'212','is_nav'=>NULL,'identifie'=>'diandi_tea','type'=>'base','title'=>'智能茶室','version'=>'1.0.0','ability'=>'智能茶室','description'=>'智能茶室','author'=>'兔兔','url'=>'3','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addons}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

