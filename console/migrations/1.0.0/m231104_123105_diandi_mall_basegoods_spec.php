<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_basegoods_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_basegoods_spec}}', [
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_basegoods_spec}}',['goods_spec_id'=>'1','store_id'=>'62','bloc_id'=>'13','goods_id'=>'2','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'1','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/13/d47c2f79-2da7-3f8b-ad1c-8c3ba4735131.jpg','create_time'=>'1657695165','update_time'=>'1657695165']);
        $this->insert('{{%diandi_mall_basegoods_spec}}',['goods_spec_id'=>'3','store_id'=>'62','bloc_id'=>'13','goods_id'=>'3','goods_no'=>'1','goods_price'=>'1.00','line_price'=>'1.00','stock_num'=>'1','goods_sales'=>'0','goods_weight'=>'1','spec_sku_id'=>'1','goods_costprice'=>'1.00','spec_item_thumb'=>'202207/14/da6d9891-5ef7-3903-8499-7520484d0f65.jpg','create_time'=>'1657785104','update_time'=>'1657785104']);
        $this->insert('{{%diandi_mall_basegoods_spec}}',['goods_spec_id'=>'6','store_id'=>'62','bloc_id'=>'13','goods_id'=>'1','goods_no'=>'1','goods_price'=>'1.00','line_price'=>'1.00','stock_num'=>'1','goods_sales'=>'0','goods_weight'=>'1','spec_sku_id'=>'2','goods_costprice'=>'1.00','spec_item_thumb'=>'202207/25/a0657277-6a10-312a-8a36-728211f2cc5e.png','create_time'=>'1658715463','update_time'=>'1658715463']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_basegoods_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

