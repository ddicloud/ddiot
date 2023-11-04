<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_order_qrcode extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_order_qrcode}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'order_id' => "int(11) NULL",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'qrcode_status' => "int(11) NULL COMMENT '核销状态'",
            'qrcode_sn' => "varchar(100) NULL COMMENT '核销码'",
            'product_id' => "int(11) NULL COMMENT '产品ID'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'order_type' => "int(11) NULL COMMENT '订单类型'",
            'check_num' => "int(11) NULL COMMENT '核销次数'",
            'check_total' => "int(11) NULL COMMENT '核销总次数'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='活动统一规则'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'1','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 19:40:59','update_time'=>'2023-03-23 19:40:59','order_id'=>'1','member_id'=>'108','qrcode_status'=>'1','qrcode_sn'=>'12023032398565448','product_id'=>'26','activity_id'=>'6','order_type'=>NULL,'check_num'=>'1','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'2','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-23 20:00:32','update_time'=>'2023-03-23 20:00:32','order_id'=>'7','member_id'=>'128','qrcode_status'=>'1','qrcode_sn'=>'12023032348525756','product_id'=>'26','activity_id'=>'6','order_type'=>NULL,'check_num'=>'1','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'3','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:08:47','update_time'=>'2023-03-23 21:08:47','order_id'=>'13','member_id'=>'108','qrcode_status'=>'0','qrcode_sn'=>'22023032310249575','product_id'=>'26','activity_id'=>'9','order_type'=>NULL,'check_num'=>'0','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'4','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:29:06','update_time'=>'2023-03-23 21:29:06','order_id'=>'16','member_id'=>'108','qrcode_status'=>'0','qrcode_sn'=>'12023032350995749','product_id'=>'26','activity_id'=>'6','order_type'=>NULL,'check_num'=>'0','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'5','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:47:13','update_time'=>'2023-03-23 21:47:13','order_id'=>'18','member_id'=>'108','qrcode_status'=>'0','qrcode_sn'=>'22023032349545150','product_id'=>'26','activity_id'=>'9','order_type'=>NULL,'check_num'=>'0','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'6','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-23 22:14:58','update_time'=>'2023-03-23 22:14:58','order_id'=>'21','member_id'=>'108','qrcode_status'=>'0','qrcode_sn'=>'52023032350995399','product_id'=>'23','activity_id'=>'11','order_type'=>NULL,'check_num'=>'0','check_total'=>'1']);
        $this->insert('{{%bea_cloud_order_qrcode}}',['id'=>'7','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-24 10:09:58','update_time'=>'2023-03-24 10:09:58','order_id'=>'22','member_id'=>'90','qrcode_status'=>'0','qrcode_sn'=>'52023032454539898','product_id'=>'22','activity_id'=>'12','order_type'=>NULL,'check_num'=>'0','check_total'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_order_qrcode}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

