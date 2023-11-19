<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_base_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_base_goods}}', [
            'goods_id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_name' => "varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称'",
            'category_pid' => "int(11) NULL COMMENT '商品父级分类'",
            'stock' => "int(11) NULL DEFAULT '0' COMMENT '库存'",
            'video' => "varchar(255) NULL COMMENT '商品视频'",
            'category_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类'",
            'spec_type' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启多规格'",
            'deduct_stock_type' => "tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '库存减少方式'",
            'thumb' => "varchar(255) NULL COMMENT '商品主图'",
            'line_price' => "decimal(10,2) NULL COMMENT '市场价格'",
            'goods_weight' => "decimal(10,0) NULL COMMENT '商品重量'",
            'volume' => "decimal(11,2) NULL COMMENT '体积'",
            'express_type' => "int(11) NULL COMMENT '1重量2体积3计件'",
            'goods_price' => "decimal(10,2) NULL COMMENT '商品售价'",
            'content' => "longtext NOT NULL COMMENT '商品介绍'",
            'sales_initial' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟销量'",
            'sales_actual' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '真实销量'",
            'goods_sort' => "int(11) unsigned NOT NULL DEFAULT '100' COMMENT '商品排序'",
            'delivery_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '运费模板'",
            'goods_status' => "tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '商品是否上架0下架1上架'",
            'goods_costprice' => "decimal(10,2) NULL",
            'is_delete' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除'",
            'goods_type' => "tinyint(3) NULL COMMENT '商品类型'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'express_template_id' => "int(11) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'images' => "text NULL COMMENT '商品相册'",
            'exemption' => "decimal(11,2) NULL COMMENT '包邮条件'",
            'exemption_type' => "int(11) NULL COMMENT '包邮计算类型'",
            'browse' => "int(11) NULL DEFAULT '0'",
            'label' => "varchar(255) NULL",
            'selling_point' => "text NULL COMMENT '产品卖点'",
            'PRIMARY KEY (`goods_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('category_id','{{%diandi_mall_base_goods}}','category_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'1','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智能门锁','category_pid'=>'1','stock'=>'97','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/14/c4a9ee33-3441-346d-b1ae-1dcbc0ec0f28.jpg','line_price'=>'1.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>1</p>','sales_initial'=>'1','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'1.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657693128','update_time'=>'1658715463','images'=>'a:1:{i:0;s:50:"202207/14/d3c590f7-3004-3564-8125-4d91d24401b3.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'402','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>1</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'4','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智能开关','category_pid'=>'1','stock'=>'378','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/27a7006c-9814-3839-ac25-536b92498400.jpg','line_price'=>'399.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'399.00','content'=>'<p>23</p>','sales_initial'=>'399','sales_actual'=>'0','goods_sort'=>'23','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'399.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881598','update_time'=>'1659009053','images'=>'a:1:{i:0;s:50:"202207/15/c22458f3-d50a-3495-be62-ad9bd9d2a7a4.jpg";}','exemption'=>'12.00','exemption_type'=>'1','browse'=>'17','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>435</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'5','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云商业授权','category_pid'=>'1','stock'=>'6','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/22/9837219c-42b9-3fb7-be6a-48479b931d24.jpg','line_price'=>'1499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>2</p>','sales_initial'=>'213','sales_actual'=>'0','goods_sort'=>'42','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'299.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881645','update_time'=>'1659010536','images'=>'a:1:{i:0;s:50:"202207/15/a88f5612-96f7-3389-884c-909afb217780.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'74','label'=>'N;','selling_point'=>'<p>3</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'6','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云单商户点单','category_pid'=>'1','stock'=>'1','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/3e3f0c2a-b6de-3816-b68b-6b947de0d0f4.jpg','line_price'=>'1.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p><br/>21</p>','sales_initial'=>'1','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'1.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881684','update_time'=>'1657881684','images'=>'a:1:{i:0;s:50:"202207/15/0ee62362-72fc-350a-996d-f2bb95429b0f.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'0','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>23</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'7','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云多商户分销','category_pid'=>'1','stock'=>'499','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/95ef878a-a23b-3029-9ff4-7619ef942be3.jpg','line_price'=>'499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>12</p>','sales_initial'=>'499','sales_actual'=>'0','goods_sort'=>'499','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'499.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881762','update_time'=>'1658297376','images'=>'a:1:{i:0;s:50:"202207/15/1e26b541-30c7-3f8d-8490-805f953c86ec.jpg";}','exemption'=>'1.00','exemption_type'=>NULL,'browse'=>'4','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>232</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'8','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智慧防控','category_pid'=>'1','stock'=>'5999','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/8809467f-5c99-3460-a3fd-12c83ba5b4a0.jpg','line_price'=>'5999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'5999.00','content'=>'<p>12</p>','sales_initial'=>'5999','sales_actual'=>'0','goods_sort'=>'5999','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'5999.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881795','update_time'=>'1659010270','images'=>'a:1:{i:0;s:50:"202207/15/8e2aaab0-ee74-3c01-bdb8-e9d306e389f1.jpg";}','exemption'=>'2.00','exemption_type'=>'1','browse'=>'1','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>23</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'9','store_id'=>'62','bloc_id'=>'13','goods_name'=>'企业党建','category_pid'=>'1','stock'=>'499','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/c265862b-fb5b-3617-acaf-dde662fe121a.jpg','line_price'=>'499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>23</p>','sales_initial'=>'499','sales_actual'=>'0','goods_sort'=>'499','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'499.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881826','update_time'=>'1659010301','images'=>'a:1:{i:0;s:50:"202207/15/39131fc0-5db8-3c95-abc3-2ee31e428df0.jpg";}','exemption'=>'12.00','exemption_type'=>'1','browse'=>'0','label'=>'N;','selling_point'=>'<p>3223</p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'13','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云品牌代理','category_pid'=>'1','stock'=>'0','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/28/2d6cbe23-32f6-3fb3-843e-ced03e13e514.png','line_price'=>'1999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'999.00','content'=>'<p>1</p>','sales_initial'=>'25','sales_actual'=>'0','goods_sort'=>'999','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'699.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1659009622','update_time'=>'1659009622','images'=>'a:1:{i:0;s:50:"202207/28/35c6c5d5-124f-3fb2-9ce4-7761d5acba26.png";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'18','label'=>'N;','selling_point'=>'<p>2<br/></p>']);
        $this->insert('{{%diandi_mall_base_goods}}',['goods_id'=>'14','store_id'=>'62','bloc_id'=>'13','goods_name'=>'花卉电商','category_pid'=>'1','stock'=>'1223','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/28/bfd115ff-9d28-3340-aeaa-9fd6efb49e42.png','line_price'=>'1999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>1</p>','sales_initial'=>'23','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'299.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1659010386','update_time'=>'1659010386','images'=>'a:1:{i:0;s:50:"202207/28/ec270e7e-c6d1-31d3-8dce-bbab59cde5d0.png";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'0','label'=>'N;','selling_point'=>'<p>2</p>']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_base_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

