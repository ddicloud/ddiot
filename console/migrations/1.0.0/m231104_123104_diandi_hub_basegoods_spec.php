<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_basegoods_spec extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_basegoods_spec}}', [
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
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'2','store_id'=>'80','bloc_id'=>'31','goods_id'=>'6','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'28','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/07/cf31ca8c-a9f5-397d-930c-b7c8b2a961ff.png','create_time'=>'1657183082','update_time'=>'1657183082']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'3','store_id'=>'80','bloc_id'=>'31','goods_id'=>'10','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'28','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/07/cf31ca8c-a9f5-397d-930c-b7c8b2a961ff.png','create_time'=>'1657183925','update_time'=>'1657183925']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'4','store_id'=>'80','bloc_id'=>'31','goods_id'=>'12','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'28','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/07/cf31ca8c-a9f5-397d-930c-b7c8b2a961ff.png','create_time'=>'1657184291','update_time'=>'1657184291']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'5','store_id'=>'80','bloc_id'=>'31','goods_id'=>'13','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'28','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/07/cf31ca8c-a9f5-397d-930c-b7c8b2a961ff.png','create_time'=>'1657184369','update_time'=>'1657184369']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'6','store_id'=>'80','bloc_id'=>'31','goods_id'=>'22','goods_no'=>'12','goods_price'=>'12.00','line_price'=>'12.00','stock_num'=>'12','goods_sales'=>'0','goods_weight'=>'12','spec_sku_id'=>'28','goods_costprice'=>'12.00','spec_item_thumb'=>'202207/07/cf31ca8c-a9f5-397d-930c-b7c8b2a961ff.png','create_time'=>'1657184615','update_time'=>'1657184615']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'7','store_id'=>'80','bloc_id'=>'31','goods_id'=>'23','goods_no'=>'45','goods_price'=>'54.00','line_price'=>'54.00','stock_num'=>'5645','goods_sales'=>'0','goods_weight'=>'545','spec_sku_id'=>'33_37','goods_costprice'=>'548.00','spec_item_thumb'=>'202207/07/49c88cd6-6de8-3848-a8bc-6446479686cf.jpg','create_time'=>'1657195170','update_time'=>'1657195170']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'8','store_id'=>'80','bloc_id'=>'31','goods_id'=>'24','goods_no'=>'45','goods_price'=>'54.00','line_price'=>'54.00','stock_num'=>'5645','goods_sales'=>'0','goods_weight'=>'545','spec_sku_id'=>'33_37','goods_costprice'=>'548.00','spec_item_thumb'=>'202207/07/49c88cd6-6de8-3848-a8bc-6446479686cf.jpg','create_time'=>'1665652820','update_time'=>'1665652820']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'9','store_id'=>'0','bloc_id'=>'0','goods_id'=>'26','goods_no'=>'100','goods_price'=>'1.00','line_price'=>'1.00','stock_num'=>'1','goods_sales'=>'0','goods_weight'=>'1','spec_sku_id'=>'81','goods_costprice'=>'1.00','spec_item_thumb'=>'202210/28/9bad0841-3124-3a46-8fbd-a21075a6a003.jpg','create_time'=>'1666954094','update_time'=>'1666954094']);
        $this->insert('{{%diandi_hub_basegoods_spec}}',['goods_spec_id'=>'10','store_id'=>'86','bloc_id'=>'35','goods_id'=>'27','goods_no'=>'11','goods_price'=>'1.00','line_price'=>'1.00','stock_num'=>'1','goods_sales'=>'0','goods_weight'=>'1','spec_sku_id'=>'82','goods_costprice'=>'1.00','spec_item_thumb'=>'202211/05/b244f0fe-cc47-337f-a1f8-9d9134a601fd.png','create_time'=>'1667642130','update_time'=>'1667642130']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_basegoods_spec}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

