<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_store_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_store_user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'bloc_id' => "int(11) NOT NULL COMMENT '公司ID'",
            'status' => "int(11) NULL COMMENT '员工状态'",
            'name' => "varchar(30) NULL COMMENT '员工姓名'",
            'mobile' => "varchar(30) NULL COMMENT '手机号'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_store_user}}',['id'=>'2','member_id'=>'73','store_id'=>'75','bloc_id'=>'29','status'=>'1','name'=>'未','mobile'=>'1213','create_time'=>'1645690115','update_time'=>'1645691478']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_store_user}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

