<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_red_packet_activity extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_red_packet_activity}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'packet_id' => "int(11) NULL COMMENT '红包活动ID'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'activity_title' => "varchar(100) NULL COMMENT '活动名称'",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'total' => "decimal(11,2) NULL COMMENT '红包总额'",
            'get_num' => "int(11) NULL COMMENT '领取人数'",
            'order_num' => "int(11) NULL COMMENT '成交人数'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='红包活动关联概率'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'1','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 21:14:49','update_time'=>'2023-03-06 21:14:49','packet_id'=>'1','activity_id'=>'1','activity_title'=>'','activity_type'=>'1','total'=>'12.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'2','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:37:21','update_time'=>'2023-03-06 22:37:21','packet_id'=>'2','activity_id'=>'4','activity_title'=>NULL,'activity_type'=>'3','total'=>'23.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'3','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:38:44','update_time'=>'2023-03-06 22:38:44','packet_id'=>'3','activity_id'=>'4','activity_title'=>NULL,'activity_type'=>'3','total'=>'23.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'4','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:41:15','update_time'=>'2023-03-06 22:41:15','packet_id'=>'4','activity_id'=>'1','activity_title'=>NULL,'activity_type'=>'1','total'=>'23.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'5','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 14:53:52','update_time'=>'2023-03-07 14:53:52','packet_id'=>'5','activity_id'=>'1','activity_title'=>NULL,'activity_type'=>'3','total'=>'99.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'6','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 14:53:52','update_time'=>'2023-03-07 14:53:52','packet_id'=>'5','activity_id'=>'1','activity_title'=>NULL,'activity_type'=>'1','total'=>'1.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'7','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 15:59:08','update_time'=>'2023-03-16 15:59:08','packet_id'=>'6','activity_id'=>NULL,'activity_title'=>NULL,'activity_type'=>'2','total'=>NULL,'get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'8','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:03:49','update_time'=>'2023-03-16 16:03:49','packet_id'=>'7','activity_id'=>'4','activity_title'=>NULL,'activity_type'=>'1','total'=>'100.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'9','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:56:13','update_time'=>'2023-03-16 16:56:13','packet_id'=>'8','activity_id'=>'4','activity_title'=>'','activity_type'=>'1','total'=>'7.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'11','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 18:58:02','update_time'=>'2023-03-16 18:58:02','packet_id'=>'9','activity_id'=>'12','activity_title'=>NULL,'activity_type'=>'3','total'=>'8.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'12','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 18:59:33','update_time'=>'2023-03-16 18:59:33','packet_id'=>'10','activity_id'=>'4','activity_title'=>'','activity_type'=>'1','total'=>'5.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'13','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:03:42','update_time'=>'2023-03-16 19:03:42','packet_id'=>'11','activity_id'=>'8','activity_title'=>NULL,'activity_type'=>'2','total'=>'9.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'14','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:22:46','update_time'=>'2023-03-16 19:22:46','packet_id'=>'12','activity_id'=>'4','activity_title'=>NULL,'activity_type'=>'1','total'=>'55.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'15','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:22:46','update_time'=>'2023-03-16 19:22:46','packet_id'=>'12','activity_id'=>'8','activity_title'=>NULL,'activity_type'=>'2','total'=>'10.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'16','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:32:16','update_time'=>'2023-03-16 19:32:16','packet_id'=>'13','activity_id'=>'8','activity_title'=>'','activity_type'=>'2','total'=>'34.00','get_num'=>NULL,'order_num'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet_activity}}',['id'=>'17','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:32:16','update_time'=>'2023-03-16 19:32:16','packet_id'=>'13','activity_id'=>'4','activity_title'=>'','activity_type'=>'1','total'=>'30.00','get_num'=>NULL,'order_num'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_red_packet_activity}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

