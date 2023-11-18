<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_account_agent extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_account_agent}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_id' => "int(10) NULL COMMENT '订单id'",
            'order_goods_id' => "int(11) NULL",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'city_mid' => "int(11) NULL COMMENT '城市代理'",
            'area_mid' => "int(11) NULL COMMENT '区县代理'",
            'provice_mid' => "int(11) NULL COMMENT '省份代理'",
            'city_radio' => "int(11) NULL COMMENT '城市比例'",
            'area_radio' => "int(11) NULL COMMENT '区县比例'",
            'provice_radio' => "int(11) NULL COMMENT '省份比例'",
            'performance' => "decimal(11,2) NULL COMMENT '礼包业绩'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'order_price' => "decimal(10,2) NULL COMMENT '订单价格'",
            'spec_id' => "int(11) NULL COMMENT '商品规格'",
            'spec_price' => "decimal(11,2) NULL COMMENT '规格价格'",
            'goods_price' => "decimal(11,2) NULL COMMENT '商品价格'",
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
        $this->dropTable('{{%diandi_hub_account_agent}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

