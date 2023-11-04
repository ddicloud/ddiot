<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_red_packet extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_red_packet}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(100) NULL COMMENT '活动名称'",
            'start_time' => "datetime NULL COMMENT '开始时间'",
            'end_time' => "datetime NULL COMMENT '结束时间'",
            'total' => "decimal(11,2) NULL COMMENT '红包总额'",
            'get_num' => "int(11) NULL COMMENT '领取人数'",
            'order_num' => "int(11) NULL COMMENT '成交人数'",
            'change_rate' => "decimal(11,2) NULL COMMENT '转化率'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='红包活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'1','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 21:14:49','update_time'=>'2023-03-06 22:40:36','title'=>'活动名称','start_time'=>'2023-03-06 21:14:40','end_time'=>'2023-03-24 00:00:00','total'=>'1000.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'2','store_id'=>'4','bloc_id'=>'1','create_time'=>'2023-03-06 22:37:21','update_time'=>'2023-03-06 22:37:21','title'=>'這個活動','start_time'=>'2023-03-06 22:37:01','end_time'=>'2023-03-31 00:00:00','total'=>'12.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'3','store_id'=>'4','bloc_id'=>'1','create_time'=>'2023-03-06 22:38:44','update_time'=>'2023-03-06 22:38:44','title'=>'23','start_time'=>'2023-03-06 22:38:25','end_time'=>'2023-03-29 00:00:00','total'=>'12.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'4','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-06 22:41:15','update_time'=>'2023-03-06 22:41:15','title'=>'好的','start_time'=>'2023-03-06 22:40:52','end_time'=>'2023-03-17 00:00:00','total'=>'500.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'5','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 14:53:52','update_time'=>'2023-03-07 14:53:52','title'=>'测试时间范围内活动','start_time'=>'2023-03-07 14:53:28','end_time'=>'2023-03-16 00:00:00','total'=>'100.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'6','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 15:59:08','update_time'=>'2023-03-16 15:59:08','title'=>'活动名称','start_time'=>'2023-03-16 15:58:46','end_time'=>'2023-03-17 00:00:00','total'=>'12.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'7','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:03:49','update_time'=>'2023-03-16 16:03:49','title'=>'活动名称','start_time'=>'2023-03-16 16:03:33','end_time'=>'2023-03-17 00:00:00','total'=>'500.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'8','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 16:56:13','update_time'=>'2023-03-16 18:34:03','title'=>'随便','start_time'=>'2023-03-16 16:56:09','end_time'=>'2023-03-18 00:00:00','total'=>'7.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'9','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 18:58:02','update_time'=>'2023-03-16 18:58:02','title'=>'红包活动2','start_time'=>'2023-03-15 00:00:00','end_time'=>'2023-03-19 00:00:00','total'=>'100.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_red_packet}}',['id'=>'13','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:32:16','update_time'=>'2023-03-16 19:32:28','title'=>'66','start_time'=>'2023-03-16 19:31:20','end_time'=>'2023-03-22 00:00:00','total'=>'66.00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_red_packet}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

