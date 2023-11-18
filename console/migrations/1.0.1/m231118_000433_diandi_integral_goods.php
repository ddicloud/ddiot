<?php

use yii\db\Migration;

class m231118_000433_diandi_integral_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods}}', [
            'goods_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_name' => "varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称'",
            'category_pid' => "int(11) NULL COMMENT '商品父级分类'",
            'video' => "varchar(255) NULL",
            'stock' => "int(11) NULL DEFAULT '0' COMMENT '库存'",
            'category_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类'",
            'spec_type' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启多规格'",
            'goods_money' => "decimal(11,2) NULL",
            'deduct_stock_type' => "tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '库存减少方式'",
            'thumb' => "varchar(255) NULL COMMENT '商品主图'",
            'line_price' => "decimal(10,2) NULL COMMENT '市场价格'",
            'goods_weight' => "decimal(10,0) NULL COMMENT '商品重量'",
            'goods_price' => "decimal(10,2) NULL COMMENT '商品售价'",
            'content' => "longtext NOT NULL COMMENT '商品介绍'",
            'sales_initial' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟销量'",
            'sales_actual' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '真实销量'",
            'goods_sort' => "int(11) unsigned NOT NULL DEFAULT '100' COMMENT '商品排序'",
            'delivery_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '运费模板'",
            'goods_status' => "tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '商品是否上架0下架1上架'",
            'is_delete' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除'",
            'goods_integral' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换积分'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'images' => "text NULL COMMENT '商品相册'",
            'browse' => "int(11) NULL DEFAULT '0'",
            'label' => "varchar(4) NULL",
            'volume' => "decimal(11,2) NOT NULL",
            'express_template_id' => "int(11) NULL",
            'express_type' => "int(11) NULL",
            'PRIMARY KEY (`goods_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('category_id','{{%diandi_integral_goods}}','category_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_goods}}',['goods_id'=>'1','store_id'=>'149','bloc_id'=>'51','goods_name'=>'商品名称','category_pid'=>'1','video'=>NULL,'stock'=>'2','category_id'=>'1','spec_type'=>'10','goods_money'=>NULL,'deduct_stock_type'=>'10','thumb'=>'202306/16/e85b8427-420c-3617-aff8-c3c822b72e10.png','line_price'=>'1.00','goods_weight'=>'2','goods_price'=>'1.00','content'=>'<p>11&nbsp;&nbsp;&nbsp;&nbsp;1</p>','sales_initial'=>'1','sales_actual'=>'11','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'0','is_delete'=>'0','goods_integral'=>'11','create_time'=>'1686896241','update_time'=>'1686896241','images'=>'a:1:{i:0;s:50:"202306/16/3da2686a-2c94-385c-bc45-e6c572ccfc20.png";}','browse'=>'7','label'=>NULL,'volume'=>'1.00','express_template_id'=>NULL,'express_type'=>'1']);
        $this->insert('{{%diandi_integral_goods}}',['goods_id'=>'2','store_id'=>'149','bloc_id'=>'51','goods_name'=>'商品二','category_pid'=>'1','video'=>NULL,'stock'=>'1','category_id'=>'1','spec_type'=>'10','goods_money'=>NULL,'deduct_stock_type'=>'10','thumb'=>'202306/16/199e34bc-03c7-39e8-9d5f-abd15a574025.png','line_price'=>'51.00','goods_weight'=>'1551','goods_price'=>'15.00','content'=>'<p>1212</p>','sales_initial'=>'151','sales_actual'=>'12','goods_sort'=>'615','delivery_id'=>'0','goods_status'=>'0','is_delete'=>'0','goods_integral'=>'12','create_time'=>'1686896289','update_time'=>'1686896289','images'=>'a:1:{i:0;s:50:"202306/16/86db19f2-17b6-3c53-a44e-5fac0591a833.png";}','browse'=>'136','label'=>NULL,'volume'=>'2.00','express_template_id'=>NULL,'express_type'=>'1']);
        $this->insert('{{%diandi_integral_goods}}',['goods_id'=>'3','store_id'=>'149','bloc_id'=>'51','goods_name'=>'商品三','category_pid'=>'1','video'=>NULL,'stock'=>'44','category_id'=>'3','spec_type'=>'10','goods_money'=>NULL,'deduct_stock_type'=>'10','thumb'=>'202306/16/31a190e5-75eb-3118-8803-7a6ad9881dbc.jpg','line_price'=>'45454.00','goods_weight'=>'4','goods_price'=>'44.00','content'=>'<p>232</p>','sales_initial'=>'4','sales_actual'=>'4','goods_sort'=>'454','delivery_id'=>'0','goods_status'=>'0','is_delete'=>'0','goods_integral'=>'122','create_time'=>'1686897402','update_time'=>'1686897402','images'=>'a:1:{i:0;s:50:"202306/16/ec0066bc-a894-3d73-a7dd-ceb9adb23689.jpg";}','browse'=>'15','label'=>NULL,'volume'=>'12.00','express_template_id'=>NULL,'express_type'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

