<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_red_packet_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_red_packet_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'get_type' => "int(11) NULL DEFAULT '0' COMMENT '0红包1商品'",
            'packet_id' => "int(11) NULL",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'money' => "decimal(11,2) NULL COMMENT '领取金额'",
            'is_buy' => "int(11) NULL COMMENT '是否购买'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'is_get' => "int(11) NULL DEFAULT '0' COMMENT '0未领取1已领取'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='红包发放记录'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_red_packet_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

