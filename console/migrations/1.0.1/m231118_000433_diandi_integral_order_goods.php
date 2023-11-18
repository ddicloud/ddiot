<?php

use yii\db\Migration;

class m231118_000433_diandi_integral_order_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_order_goods}}', [
            'order_goods_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(255) NULL",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'goods_name' => "varchar(255) NOT NULL DEFAULT ''",
            'thumb' => "varchar(255) NOT NULL DEFAULT '0'",
            'stock_up' => "int(11) NULL DEFAULT '0' COMMENT '库存是否处理'",
            'deduct_stock_type' => "tinyint(3) unsigned NULL DEFAULT '20'",
            'spec_type' => "tinyint(3) unsigned NULL DEFAULT '0'",
            'spec_sku_id' => "varchar(255) NULL DEFAULT ''",
            'goods_spec_id' => "int(11) unsigned NULL DEFAULT '0'",
            'goods_attr' => "varchar(500) NULL DEFAULT ''",
            'content' => "longtext NULL",
            'goods_no' => "varchar(100) NULL DEFAULT ''",
            'goods_price' => "decimal(10,2) unsigned NOT NULL",
            'goods_integral' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'goods_weight' => "double unsigned NOT NULL DEFAULT '0'",
            'total_num' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'total_price' => "decimal(10,2) unsigned NOT NULL",
            'order_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'user_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下单人'",
            'exchange_status' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'remark' => "varchar(255) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`order_goods_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'1','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'3','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1686910005','update_time'=>'1686910005']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'2','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'4','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1686910123','update_time'=>'1686910123']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'3','bloc_id'=>'38','store_id'=>'138','goods_id'=>'3','goods_name'=>'商品三','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/31a190e5-75eb-3118-8803-7a6ad9881dbc.jpg','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>232</p>','goods_no'=>NULL,'goods_price'=>'44.00','goods_integral'=>'122','goods_weight'=>'4','total_num'=>'0','total_price'=>'0.00','order_id'=>'5','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1686910236','update_time'=>'1686910236']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'4','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'6','user_id'=>'1','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687136958','update_time'=>'1687136958']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'5','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'7','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687137146','update_time'=>'1687137146']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'6','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'8','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687137204','update_time'=>'1687137204']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'7','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'9','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687137459','update_time'=>'1687137459']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'8','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'10','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687137851','update_time'=>'1687137851']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'9','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'11','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687138115','update_time'=>'1687138115']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'10','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'12','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687138445','update_time'=>'1687138445']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'11','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'13','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687138603','update_time'=>'1687138603']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'12','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'14','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687139081','update_time'=>'1687139081']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'13','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'15','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687139146','update_time'=>'1687139146']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'14','bloc_id'=>'38','store_id'=>'138','goods_id'=>'2','goods_name'=>'商品二','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>1212</p>','goods_no'=>NULL,'goods_price'=>'15.00','goods_integral'=>'12','goods_weight'=>'1551','total_num'=>'0','total_price'=>'0.00','order_id'=>'16','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687140909','update_time'=>'1687140909']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'15','bloc_id'=>'38','store_id'=>'138','goods_id'=>'3','goods_name'=>'商品三','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/31a190e5-75eb-3118-8803-7a6ad9881dbc.jpg','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>232</p>','goods_no'=>NULL,'goods_price'=>'44.00','goods_integral'=>'122','goods_weight'=>'4','total_num'=>'0','total_price'=>'0.00','order_id'=>'17','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687141223','update_time'=>'1687141223']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'16','bloc_id'=>'38','store_id'=>'138','goods_id'=>'1','goods_name'=>'商品名称','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/e85b8427-420c-3617-aff8-c3c822b72e10.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>11&nbsp;&nbsp;&nbsp;&nbsp;1</p>','goods_no'=>NULL,'goods_price'=>'1.00','goods_integral'=>'11','goods_weight'=>'2','total_num'=>'0','total_price'=>'0.00','order_id'=>'18','user_id'=>'278','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687170015','update_time'=>'1687170015']);
        $this->insert('{{%diandi_integral_order_goods}}',['order_goods_id'=>'17','bloc_id'=>'91','store_id'=>'153','goods_id'=>'1','goods_name'=>'商品名称','thumb'=>'https://hotelapi.ddicms.cn/attachment/202306/16/e85b8427-420c-3617-aff8-c3c822b72e10.png','stock_up'=>'1','deduct_stock_type'=>'10','spec_type'=>'1','spec_sku_id'=>'','goods_spec_id'=>'0','goods_attr'=>NULL,'content'=>'<p>11&nbsp;&nbsp;&nbsp;&nbsp;1</p>','goods_no'=>NULL,'goods_price'=>'1.00','goods_integral'=>'11','goods_weight'=>'2','total_num'=>'0','total_price'=>'0.00','order_id'=>'19','user_id'=>'1','exchange_status'=>'0','remark'=>NULL,'create_time'=>'1687996529','update_time'=>'1687996529']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_order_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

