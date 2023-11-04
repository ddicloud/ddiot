<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_tuan extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_tuan}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'tuan_num' => "int(11) NULL COMMENT '人数'",
            'tuan_price' => "decimal(10,2) NULL COMMENT '发起价格'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'order_id' => "int(11) NULL COMMENT '订单ID'",
            'total_time' => "int(11) NULL COMMENT '总时间'",
            'status' => "int(11) NULL COMMENT '拼团状态'",
            'is_fictitious' => "int(11) NULL COMMENT '是否是虚拟人'",
            'is_leader' => "int(11) NULL COMMENT '是否是团长'",
            'pid' => "int(11) NULL COMMENT '团ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_tuan}}',['id'=>'1','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-24 11:12:05','update_time'=>'2023-03-24 11:12:05','member_id'=>'124','tuan_num'=>'3','tuan_price'=>'0.50','activity_id'=>'13','order_id'=>'23','total_time'=>'1','status'=>'0','is_fictitious'=>'0','is_leader'=>'1','pid'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_tuan}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

