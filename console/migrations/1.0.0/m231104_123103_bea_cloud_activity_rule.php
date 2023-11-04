<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_rule extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_rule}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'is_leader_price' => "tinyint(4) NULL COMMENT '是否开启团长价格'",
            'leader_price' => "decimal(10,2) NULL COMMENT '团长价格'",
            'is_award' => "tinyint(4) NULL COMMENT '是否开启成团奖励'",
            'award_money' => "decimal(11,2) NULL COMMENT '每人奖励金额'",
            'share1_money' => "decimal(11,2) NULL COMMENT '一级佣金'",
            'share2_money' => "decimal(11,2) NULL COMMENT '二级佣金'",
            'customer_types' => "varchar(100) NULL COMMENT '回馈客户标签'",
            'customer_money' => "decimal(11,2) NULL COMMENT '回馈金额'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='活动统一规则'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'30','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:23:48','update_time'=>'2023-03-15 11:23:48','activity_id'=>'3','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'28','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 10:29:24','update_time'=>'2023-03-15 10:29:24','activity_id'=>'11','activity_type'=>'3','is_leader_price'=>'1','leader_price'=>'0.50','is_award'=>'1','award_money'=>'0.10','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'2','customer_money'=>'0.20']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'38','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 16:26:26','update_time'=>'2023-03-15 16:26:26','activity_id'=>'5','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'27','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 10:21:43','update_time'=>'2023-03-15 10:21:43','activity_id'=>'10','activity_type'=>'3','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'26','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 16:15:40','update_time'=>'2023-03-15 16:15:40','activity_id'=>'2','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'0','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'25','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-14 13:50:13','update_time'=>'2023-03-14 13:50:13','activity_id'=>'1','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'1,2,3','customer_money'=>'3.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'24','store_id'=>'138','bloc_id'=>'3','create_time'=>'2023-03-06 15:12:51','update_time'=>'2023-03-06 15:12:51','activity_id'=>'2','activity_type'=>'3','is_leader_price'=>'1','leader_price'=>'1.00','is_award'=>'1','award_money'=>'2.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'1','customer_money'=>'33.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'20','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:33:59','update_time'=>'2023-03-15 11:33:59','activity_id'=>'1','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'0','customer_money'=>'22.11']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'22','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 17:05:27','update_time'=>'2023-03-07 17:05:27','activity_id'=>'8','activity_type'=>'3','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'23','store_id'=>'143','bloc_id'=>'39','create_time'=>'2023-03-09 19:51:10','update_time'=>'2023-03-09 19:51:10','activity_id'=>'9','activity_type'=>'3','is_leader_price'=>'1','leader_price'=>'112.00','is_award'=>'1','award_money'=>'23.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'1,2','customer_money'=>'3.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'14','store_id'=>'138','bloc_id'=>'3','create_time'=>'2023-03-06 15:12:51','update_time'=>'2023-03-06 15:12:51','activity_id'=>'1','activity_type'=>'3','is_leader_price'=>'1','leader_price'=>'1.00','is_award'=>'1','award_money'=>'2.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'1','customer_money'=>'33.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'33','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:33:13','update_time'=>'2023-03-15 11:33:13','activity_id'=>'6','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'29','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:21:20','update_time'=>'2023-03-15 11:21:20','activity_id'=>'2','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'32','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:32:28','update_time'=>'2023-03-15 11:32:28','activity_id'=>'5','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'31','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:32:06','update_time'=>'2023-03-15 11:32:06','activity_id'=>'4','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'34','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:33:59','update_time'=>'2023-03-15 11:33:59','activity_id'=>'7','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'0,2,3,1','customer_money'=>'1.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'35','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 10:21:43','update_time'=>'2023-03-15 10:21:43','activity_id'=>'5','activity_type'=>'3','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'0','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'36','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 13:43:02','update_time'=>'2023-03-15 13:43:02','activity_id'=>'3','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'37','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 16:15:40','update_time'=>'2023-03-15 16:15:40','activity_id'=>'4','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'0,2,1,3','customer_money'=>'45.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'39','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 20:37:05','update_time'=>'2023-03-15 20:37:05','activity_id'=>'8','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'12.00','share2_money'=>'1.00','customer_types'=>'0','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'40','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 21:56:55','update_time'=>'2023-03-15 21:56:55','activity_id'=>'12','activity_type'=>'3','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'0','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'41','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 11:03:38','update_time'=>'2023-03-20 11:03:38','activity_id'=>'6','activity_type'=>'1','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'2.00','share2_money'=>'1.00','customer_types'=>'0,1','customer_money'=>'2.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'42','store_id'=>'1','bloc_id'=>'0','create_time'=>'2023-03-23 20:46:53','update_time'=>'2023-03-23 20:46:53','activity_id'=>'9','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'2.00','share2_money'=>'1.00','customer_types'=>'0,2','customer_money'=>'0.40']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'43','store_id'=>'0','bloc_id'=>'0','create_time'=>'2023-03-23 20:48:43','update_time'=>'2023-03-23 20:48:43','activity_id'=>'10','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>'1.00','share2_money'=>'2.00','customer_types'=>'0,2','customer_money'=>'1.00']);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'44','store_id'=>'0','bloc_id'=>'0','create_time'=>'2023-03-23 20:52:30','update_time'=>'2023-03-23 20:52:30','activity_id'=>'11','activity_type'=>'2','is_leader_price'=>'0','leader_price'=>'0.00','is_award'=>'0','award_money'=>'0.00','share1_money'=>NULL,'share2_money'=>NULL,'customer_types'=>'','customer_money'=>NULL]);
        $this->insert('{{%bea_cloud_activity_rule}}',['id'=>'45','store_id'=>'1','bloc_id'=>'0','create_time'=>'2023-03-23 22:02:29','update_time'=>'2023-03-23 22:02:29','activity_id'=>'13','activity_type'=>'3','is_leader_price'=>'1','leader_price'=>'0.40','is_award'=>'1','award_money'=>'1.00','share1_money'=>'3.00','share2_money'=>'2.00','customer_types'=>'2','customer_money'=>'0.10']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_rule}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

