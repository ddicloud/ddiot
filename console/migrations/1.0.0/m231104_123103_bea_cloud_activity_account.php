<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_account extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_account}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'pay_order_id' => "int(11) NULL COMMENT '订单ID'",
            'money' => "decimal(11,2) NULL COMMENT '收益金额'",
            'fanid' => "int(11) NULL COMMENT '粉丝ID'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='活动统一规则'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'3','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'1','member_id'=>'1']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'4','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'2','member_id'=>'2']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'5','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'3','member_id'=>'31']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'6','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'4','member_id'=>'4']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'7','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'5','member_id'=>'5']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'8','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'6','member_id'=>'6']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'9','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'7','member_id'=>'7']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'10','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'8']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'11','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'8']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'12','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'8']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'13','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'8']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'14','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'8']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'15','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'1']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'16','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'2']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'17','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'3']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'18','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','pay_order_id'=>'1','money'=>'1.00','fanid'=>'8','member_id'=>'4']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'19','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:29:06','update_time'=>'2023-03-23 21:29:06','activity_type'=>'1','activity_id'=>'6','pay_order_id'=>'16','money'=>'2.00','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_account}}',['id'=>'20','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:47:13','update_time'=>'2023-03-23 21:47:13','activity_type'=>'2','activity_id'=>'9','pay_order_id'=>'18','money'=>'2.00','fanid'=>'86','member_id'=>'124']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_account}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

