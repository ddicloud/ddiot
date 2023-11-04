<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_red_packet_money extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_red_packet_money}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'packet_id' => "int(11) NULL",
            'total' => "decimal(11,2) NULL COMMENT '红包金额'",
            'probability' => "decimal(11,2) NULL COMMENT '概率'",
            'get_num' => "int(11) NULL COMMENT '领取人数'",
            'order_num' => "int(11) NULL COMMENT '成交人数'",
            'change_rate' => "decimal(11,2) NULL COMMENT '转化率'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='红包活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'1','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 21:14:49','update_time'=>'2023-03-06 21:14:49','packet_id'=>'1','total'=>'55.00','probability'=>'2.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'2','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:37:21','update_time'=>'2023-03-06 22:37:21','packet_id'=>'2','total'=>'1.00','probability'=>'2.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'3','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:38:44','update_time'=>'2023-03-06 22:38:44','packet_id'=>'3','total'=>'1.00','probability'=>'2.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'4','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:41:15','update_time'=>'2023-03-06 22:41:15','packet_id'=>'4','total'=>'12.00','probability'=>'23.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'5','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 14:53:52','update_time'=>'2023-03-07 14:53:52','packet_id'=>'5','total'=>'1.00','probability'=>'3.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'6','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 14:53:52','update_time'=>'2023-03-07 14:53:52','packet_id'=>'5','total'=>'2.00','probability'=>'4.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'7','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 15:59:08','update_time'=>'2023-03-16 15:59:08','packet_id'=>'6','total'=>'0.00','probability'=>'0.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'8','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:03:49','update_time'=>'2023-03-16 16:03:49','packet_id'=>'7','total'=>'1.00','probability'=>'20.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'9','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:03:49','update_time'=>'2023-03-16 16:03:49','packet_id'=>'7','total'=>'2.00','probability'=>'30.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'10','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:03:49','update_time'=>'2023-03-16 16:03:49','packet_id'=>'7','total'=>'3.00','probability'=>'20.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'15','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 18:59:33','update_time'=>'2023-03-16 18:59:33','packet_id'=>'10','total'=>'0.01','probability'=>'20.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'14','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 18:58:02','update_time'=>'2023-03-16 18:58:02','packet_id'=>'9','total'=>'0.01','probability'=>'10.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'13','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:56:13','update_time'=>'2023-03-16 16:56:13','packet_id'=>'8','total'=>'5.00','probability'=>'28.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'16','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:03:42','update_time'=>'2023-03-16 19:03:42','packet_id'=>'11','total'=>'0.01','probability'=>'8.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'17','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:22:46','update_time'=>'2023-03-16 19:22:46','packet_id'=>'12','total'=>'0.01','probability'=>'20.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'18','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:22:46','update_time'=>'2023-03-16 19:22:46','packet_id'=>'12','total'=>'1.00','probability'=>'5.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'19','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:32:16','update_time'=>'2023-03-16 19:32:16','packet_id'=>'13','total'=>'1.00','probability'=>'10.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_money}}',['id'=>'20','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:32:16','update_time'=>'2023-03-16 19:32:16','packet_id'=>'13','total'=>'0.10','probability'=>'80.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_red_packet_money}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

