<?php

use yii\db\Migration;

class m231104_123104_diandi_integral_goods_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods_spec}}', [
            'goods_spec_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性id'",
            'store_id' => "int(11) NULL COMMENT '商户的'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id'",
            'goods_no' => "varchar(100) NOT NULL DEFAULT '' COMMENT '商品编码'",
            'goods_price' => "decimal(10,2) unsigned NOT NULL COMMENT '销售价格'",
            'line_price' => "decimal(10,2) unsigned NOT NULL COMMENT '市场价格'",
            'stock_num' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存'",
            'goods_sales' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品销量'",
            'goods_weight' => "double unsigned NOT NULL DEFAULT '0' COMMENT '重量'",
            'spec_sku_id' => "varchar(255) NOT NULL DEFAULT '' COMMENT '商品规格组合id'",
            'goods_costprice' => "decimal(10,2) NULL COMMENT '成本价格'",
            'spec_item_thumb' => "varchar(255) NULL COMMENT '商品属性图片'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`goods_spec_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

