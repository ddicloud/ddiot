<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_express_company extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_express_company}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'title' => "varchar(255) NULL COMMENT '名称'",
            'code' => "varchar(255) NULL COMMENT '编码'",
            'status' => "int(255) NULL DEFAULT '0' COMMENT '是否启用'",
            'display_order' => "int(11) NULL COMMENT '排序'",
            'mobile' => "varchar(20) NULL COMMENT '联系电话'",
            'link_man' => "varchar(30) NULL COMMENT '联系人'",
            'is_default' => "int(11) NULL COMMENT '是否默认'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_express_company}}',['id'=>'1','title'=>'顺丰','code'=>'shunf','status'=>'1','display_order'=>'1','mobile'=>'15645','link_man'=>'王春生','is_default'=>'0','create_time'=>NULL,'update_time'=>'1646102238']);
        $this->insert('{{%diandi_hub_express_company}}',['id'=>'2','title'=>'测试','code'=>NULL,'status'=>'1','display_order'=>NULL,'mobile'=>'0','link_man'=>'000','is_default'=>'0','create_time'=>'1653472472','update_time'=>'1653472472']);
        $this->insert('{{%diandi_hub_express_company}}',['id'=>'3','title'=>'运费001','code'=>'00023','status'=>'1','display_order'=>NULL,'mobile'=>'157854895','link_man'=>'王春生','is_default'=>'1','create_time'=>'1655339934','update_time'=>'1655339934']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_express_company}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

