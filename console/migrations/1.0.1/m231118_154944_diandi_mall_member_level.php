<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_member_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_member_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'is_store' => "int(11) NOT NULL DEFAULT '0' COMMENT '是否是店主'",
            'member_store_id' => "varchar(30) NOT NULL COMMENT '我的店铺'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'member_pid' => "int(11) NULL COMMENT '上级id'",
            'level_pid_num' => "int(11) NULL COMMENT '上级的等级'",
            'level_num' => "int(11) NULL COMMENT '等级'",
            'family' => "text NULL COMMENT '下级家族'",
            'end_time' => "int(11) NULL DEFAULT '0' COMMENT '权益有效期'",
            'create_time' => "int(11) NULL COMMENT '注册时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_member_level}}','member_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_member_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

