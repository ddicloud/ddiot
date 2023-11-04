<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_free_activity extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_free_activity}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'free_id' => "int(11) NULL COMMENT '活动ID'",
            'title' => "varchar(100) NULL COMMENT '活动名称'",
            'start_time' => "datetime NULL COMMENT '开始时间'",
            'end_time' => "datetime NULL COMMENT '结束时间'",
            'get_num' => "int(11) NULL COMMENT '领取人数'",
            'order_num' => "int(11) NULL COMMENT '订单人数'",
            'change_rate' => "decimal(11,2) NULL COMMENT '转化率'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='红包活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'9','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-09 21:17:56','update_time'=>'2023-03-09 21:17:56','free_id'=>NULL,'title'=>'测试领取','start_time'=>'2023-03-09 21:17:44','end_time'=>'2023-03-10 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'8','store_id'=>'146','bloc_id'=>'38','create_time'=>'2023-03-08 13:40:27','update_time'=>'2023-03-08 13:40:27','free_id'=>NULL,'title'=>'test','start_time'=>'2023-03-01 00:00:00','end_time'=>'2023-03-08 13:40:23','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'4','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 16:12:47','update_time'=>'2023-03-07 16:12:47','free_id'=>NULL,'title'=>'2222222222','start_time'=>'2023-03-01 00:00:00','end_time'=>'2023-03-31 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'5','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 16:14:59','update_time'=>'2023-03-07 16:22:07','free_id'=>NULL,'title'=>'成测试','start_time'=>'2023-03-07 16:14:50','end_time'=>'2023-03-10 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'6','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 16:16:41','update_time'=>'2023-03-07 16:16:41','free_id'=>NULL,'title'=>'成测试','start_time'=>'2023-03-07 16:14:50','end_time'=>'2023-03-10 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'7','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 16:23:09','update_time'=>'2023-03-07 16:23:09','free_id'=>NULL,'title'=>'12','start_time'=>'2023-03-07 16:23:05','end_time'=>'2023-03-07 16:23:06','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'10','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-16 09:53:53','update_time'=>'2023-03-16 18:52:32','free_id'=>NULL,'title'=>'免费领取商品','start_time'=>'2023-03-16 00:00:00','end_time'=>'2023-03-20 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'11','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:31:07','update_time'=>'2023-03-18 09:46:34','free_id'=>NULL,'title'=>'12','start_time'=>'2023-03-16 19:30:58','end_time'=>'2023-03-24 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'12','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-18 09:46:55','update_time'=>'2023-03-18 09:59:31','free_id'=>NULL,'title'=>'测试添加','start_time'=>'2023-03-23 09:46:46','end_time'=>'2023-03-31 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        $this->insert('{{%bea_cloud_free_activity}}',['id'=>'13','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-18 15:22:22','update_time'=>'2023-03-18 15:22:22','free_id'=>NULL,'title'=>'测试修改','start_time'=>'2023-03-23 00:00:00','end_time'=>'2023-03-30 00:00:00','get_num'=>NULL,'order_num'=>NULL,'change_rate'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_free_activity}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

