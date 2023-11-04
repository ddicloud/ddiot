<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_account_team_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_team_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_id' => "int(10) NULL COMMENT '订单id'",
            'order_goods_id' => "int(11) NULL",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'selflevel_num' => "int(11) NULL COMMENT '下单人等级'",
            'level_num' => "int(11) NULL COMMENT '会员等级'",
            'levelnum' => "int(11) NULL COMMENT '会员等级人数'",
            'level_mid' => "int(11) NULL COMMENT '团队id'",
            'level1_mid' => "int(11) NULL COMMENT '分销一级用户'",
            'level2_mid' => "int(10) NULL COMMENT '分销二级用户'",
            'level3_mid' => "int(11) NULL COMMENT '分销三级用户'",
            'team_radio' => "decimal(11,2) NULL COMMENT '团队奖励比例'",
            'money' => "decimal(11,2) NULL COMMENT '团队奖励'",
            'performance' => "decimal(11,2) NULL COMMENT '礼包业绩'",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=FIXED");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_account_team_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

