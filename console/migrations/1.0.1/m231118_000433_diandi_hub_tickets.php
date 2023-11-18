<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_tickets extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_tickets}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '企业ID'",
            'store_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '商户ID'",
            'user_id' => "int(11) NOT NULL COMMENT '会员ID'",
            'order_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '订单ID'",
            'product_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '产品ID'",
            'topic' => "varchar(45) NOT NULL COMMENT '主题'",
            'type' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型'",
            'content' => "varchar(900) NOT NULL COMMENT '内容'",
            'status' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='工单'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_tickets}}',['id'=>'1','bloc_id'=>'31','store_id'=>'80','user_id'=>'1004','order_id'=>'91','product_id'=>'0','topic'=>'test','type'=>'1','content'=>'test','status'=>'1','created_at'=>'2022-09-21 18:13:12','updated_at'=>'2022-09-23 15:31:48']);
        $this->insert('{{%diandi_hub_tickets}}',['id'=>'2','bloc_id'=>'31','store_id'=>'80','user_id'=>'1004','order_id'=>'0','product_id'=>'22','topic'=>'test','type'=>'2','content'=>'test','status'=>'1','created_at'=>'2022-09-21 18:14:58','updated_at'=>'2022-09-21 18:14:58']);
        $this->insert('{{%diandi_hub_tickets}}',['id'=>'3','bloc_id'=>'31','store_id'=>'80','user_id'=>'31','order_id'=>'0','product_id'=>'2','topic'=>'test','type'=>'2','content'=>'test','status'=>'1','created_at'=>'2022-10-12 14:20:55','updated_at'=>'2022-10-12 14:20:55']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_tickets}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

