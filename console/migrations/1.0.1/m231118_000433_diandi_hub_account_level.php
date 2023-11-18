<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_account_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_goods_id' => "int(11) NULL",
            'order_id' => "int(10) NULL COMMENT '订单id'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'level_mid' => "int(11) NULL COMMENT '用户id'",
            'selflevel_num' => "int(11) NULL COMMENT '下单人等级'",
            'level_num' => "int(11) NULL COMMENT '团队等级'",
            'levelnum' => "int(11) NULL COMMENT '团队等级人数'",
            'level_dis' => "int(11) NULL COMMENT '分销等级'",
            'level_radio' => "decimal(11,2) NULL COMMENT '奖励比例'",
            'money' => "decimal(11,2) NULL COMMENT '用户奖励金额'",
            'teamnum' => "int(11) NULL COMMENT '团队人数'",
            'teamsale' => "decimal(11,2) NULL COMMENT '团队销售额'",
            'selfsale' => "decimal(11,2) NULL COMMENT '我的累计消费'",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_account_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

