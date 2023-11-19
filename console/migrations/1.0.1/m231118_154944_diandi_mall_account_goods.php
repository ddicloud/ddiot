<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_account_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_account_goods}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'order_goods_id' => "int(11) NULL",
            'member_id' => "int(11) NULL COMMENT '下单人'",
            'self_level' => "int(11) NULL COMMENT '我的等级'",
            'store_id' => "int(11) NULL COMMENT '商户的'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id'",
            'goods_no' => "varchar(100) NOT NULL DEFAULT '' COMMENT '商品编码'",
            'goods_price' => "decimal(10,2) unsigned NOT NULL COMMENT '销售价格'",
            'line_price' => "decimal(10,2) unsigned NOT NULL COMMENT '市场价格'",
            'type' => "int(11) NULL COMMENT '分佣类型'",
            'money' => "decimal(11,2) NULL",
            'dislevel' => "int(11) NULL COMMENT '佣金'",
            'spec_sku_str' => "varchar(255) NOT NULL DEFAULT '' COMMENT '商品规格'",
            'goods_costprice' => "decimal(10,2) NULL COMMENT '成本价格'",
            'performance' => "decimal(11,2) NULL COMMENT '礼包奖励'",
            'levelnum' => "int(11) NULL",
            'price6' => "decimal(11,2) NULL",
            'price5' => "decimal(11,2) NULL",
            'price4' => "decimal(11,2) NULL",
            'price3' => "decimal(11,2) NULL",
            'price2' => "decimal(11,2) NULL",
            'price1' => "decimal(11,2) NULL",
            'row_col_levelnum' => "varchar(50) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('row_col_levelnum','{{%diandi_mall_account_goods}}','row_col_levelnum, goods_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_account_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

