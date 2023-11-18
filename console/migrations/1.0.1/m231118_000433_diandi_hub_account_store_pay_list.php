<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_account_store_pay_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_store_pay_list}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'member_store_id' => "int(11) NULL",
            'order_id' => "varchar(30) NOT NULL COMMENT '订单ID'",
            'name' => "varchar(11) NULL COMMENT '收费项'",
            'goods_id' => "int(11) NOT NULL COMMENT '商品id'",
            'goods_price' => "decimal(11,2) NULL COMMENT '商品价格'",
            'goods_num' => "int(11) NOT NULL COMMENT '商品数量'",
            'update_time' => "int(11) NULL COMMENT '创建时间'",
            'create_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_account_store_pay_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

