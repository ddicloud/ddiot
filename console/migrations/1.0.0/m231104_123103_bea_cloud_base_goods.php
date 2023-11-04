<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_base_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_base_goods}}', [
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
            'line_price' => "decimal(10,2) NULL DEFAULT '0.00' COMMENT '市场价格'",
            'goods_weight' => "decimal(10,0) NULL DEFAULT '0' COMMENT '商品重量'",
            'volume' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '体积'",
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
            'selling_point' => "text NULL COMMENT '宝贝概述'",
            'is_check_num' => "int(11) NULL DEFAULT '0'",
            'check_num' => "int(11) NULL DEFAULT '1'",
            'PRIMARY KEY (`goods_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('category_id','{{%bea_cloud_base_goods}}','category_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'1','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智能门锁','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/14/c4a9ee33-3441-346d-b1ae-1dcbc0ec0f28.jpg','line_price'=>'1.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>1</p>','sales_initial'=>'1','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'1.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657693128','update_time'=>'1658715463','images'=>'a:1:{i:0;s:50:"202207/14/d3c590f7-3004-3564-8125-4d91d24401b3.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'473','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>1</p>','is_check_num'=>'1','check_num'=>'5']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'4','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智能开关','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/27a7006c-9814-3839-ac25-536b92498400.jpg','line_price'=>'399.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'399.00','content'=>'<p>23</p>','sales_initial'=>'399','sales_actual'=>'0','goods_sort'=>'23','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'399.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881598','update_time'=>'1659009053','images'=>'a:1:{i:0;s:50:"202207/15/c22458f3-d50a-3495-be62-ad9bd9d2a7a4.jpg";}','exemption'=>'12.00','exemption_type'=>'1','browse'=>'29','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>435</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'5','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云商业授权','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/22/9837219c-42b9-3fb7-be6a-48479b931d24.jpg','line_price'=>'1499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>2</p>','sales_initial'=>'213','sales_actual'=>'0','goods_sort'=>'42','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'299.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881645','update_time'=>'1659010536','images'=>'a:1:{i:0;s:50:"202207/15/a88f5612-96f7-3389-884c-909afb217780.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'77','label'=>'N;','selling_point'=>'<p>3</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'6','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云单商户点单','category_pid'=>'1','stock'=>'100','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/3e3f0c2a-b6de-3816-b68b-6b947de0d0f4.jpg','line_price'=>'1.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p><br/>21</p>','sales_initial'=>'1','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'1.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881684','update_time'=>'1657881684','images'=>'a:1:{i:0;s:50:"202207/15/0ee62362-72fc-350a-996d-f2bb95429b0f.jpg";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'0','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>23</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'7','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云多商户分销','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/95ef878a-a23b-3029-9ff4-7619ef942be3.jpg','line_price'=>'499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>12</p>','sales_initial'=>'499','sales_actual'=>'0','goods_sort'=>'499','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'499.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881762','update_time'=>'1658297376','images'=>'a:1:{i:0;s:50:"202207/15/1e26b541-30c7-3f8d-8490-805f953c86ec.jpg";}','exemption'=>'1.00','exemption_type'=>NULL,'browse'=>'4','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>232</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'8','store_id'=>'62','bloc_id'=>'13','goods_name'=>'智慧防控','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/8809467f-5c99-3460-a3fd-12c83ba5b4a0.jpg','line_price'=>'5999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'5999.00','content'=>'<p>12</p>','sales_initial'=>'5999','sales_actual'=>'0','goods_sort'=>'5999','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'5999.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881795','update_time'=>'1659010270','images'=>'a:1:{i:0;s:50:"202207/15/8e2aaab0-ee74-3c01-bdb8-e9d306e389f1.jpg";}','exemption'=>'2.00','exemption_type'=>'1','browse'=>'1','label'=>'a:1:{i:0;s:1:"1";}','selling_point'=>'<p>23</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'9','store_id'=>'62','bloc_id'=>'13','goods_name'=>'企业党建','category_pid'=>'1','stock'=>'100','video'=>'','category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/15/c265862b-fb5b-3617-acaf-dde662fe121a.jpg','line_price'=>'499.00','goods_weight'=>'2','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>23</p>','sales_initial'=>'499','sales_actual'=>'0','goods_sort'=>'499','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'499.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1657881826','update_time'=>'1659010301','images'=>'a:1:{i:0;s:50:"202207/15/39131fc0-5db8-3c95-abc3-2ee31e428df0.jpg";}','exemption'=>'12.00','exemption_type'=>'1','browse'=>'0','label'=>'N;','selling_point'=>'<p>3223</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'13','store_id'=>'62','bloc_id'=>'13','goods_name'=>'店滴云品牌代理','category_pid'=>'1','stock'=>'100','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/28/2d6cbe23-32f6-3fb3-843e-ced03e13e514.png','line_price'=>'1999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'999.00','content'=>'<p>1</p>','sales_initial'=>'25','sales_actual'=>'0','goods_sort'=>'999','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'699.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1659009622','update_time'=>'1659009622','images'=>'a:1:{i:0;s:50:"202207/28/35c6c5d5-124f-3fb2-9ce4-7761d5acba26.png";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'18','label'=>'N;','selling_point'=>'<p>2<br/></p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'14','store_id'=>'62','bloc_id'=>'13','goods_name'=>'花卉电商','category_pid'=>'1','stock'=>'100','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/28/bfd115ff-9d28-3340-aeaa-9fd6efb49e42.png','line_price'=>'1999.00','goods_weight'=>'1','volume'=>'1.00','express_type'=>NULL,'goods_price'=>'499.00','content'=>'<p>1</p>','sales_initial'=>'23','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'299.00','is_delete'=>'0','goods_type'=>'2','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1659010386','update_time'=>'1659010386','images'=>'a:1:{i:0;s:50:"202207/28/ec270e7e-c6d1-31d3-8dce-bbab59cde5d0.png";}','exemption'=>'1.00','exemption_type'=>'1','browse'=>'0','label'=>'N;','selling_point'=>'<p>2</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'15','store_id'=>'139','bloc_id'=>'38','goods_name'=>'商品名称','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/03/f65e0faa-1a8c-31c6-b0ea-b705518a3295.png','line_price'=>'45.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'12.00','content'=>'<p>23424</p>','sales_initial'=>'2','sales_actual'=>'0','goods_sort'=>'5','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'145.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677837663','update_time'=>'1677837663','images'=>'a:1:{i:0;s:50:"202303/03/6c453eaa-001b-3467-b87f-e309f06c7f3c.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>2324</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'16','store_id'=>'139','bloc_id'=>'38','goods_name'=>'授权商品门店','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/bd060651-8e5a-37c5-a055-51986963d6cf.png','line_price'=>'23.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'12.00','content'=>'<p>23</p>','sales_initial'=>'21','sales_actual'=>'0','goods_sort'=>'3','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'342.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677902742','update_time'=>'1677902742','images'=>'a:1:{i:0;s:50:"202303/04/6e45802c-f3db-3f92-8b3a-12bb6f8d4fab.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>34</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'17','store_id'=>'139','bloc_id'=>'38','goods_name'=>'授权门店','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/aca798d4-bc36-3322-8bf3-7fdb8e1addef.png','line_price'=>'21.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'12.00','content'=>'<p>1223</p>','sales_initial'=>'12','sales_actual'=>'0','goods_sort'=>'23','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'32.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677902862','update_time'=>'1677902862','images'=>'a:1:{i:0;s:50:"202303/04/be9a7ee0-85fb-3f0e-aba7-f5c6208d4c9b.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>3434</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'18','store_id'=>'139','bloc_id'=>'38','goods_name'=>'门店展示商品','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/d3e2fa58-73c8-312f-b016-eb8dfb7b0bb7.png','line_price'=>'12.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'12.00','content'=>'<p>12</p>','sales_initial'=>'1','sales_actual'=>'0','goods_sort'=>'23','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'3.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677909075','update_time'=>'1677909075','images'=>'a:1:{i:0;s:50:"202303/04/0f529a10-f194-3397-a619-e0f80692c549.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>23</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'19','store_id'=>'139','bloc_id'=>'38','goods_name'=>'门店的商品001','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/929bfad7-f9d2-37ed-960b-251ec2dfe905.png','line_price'=>'1.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>12</p>','sales_initial'=>'11','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'11.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677909489','update_time'=>'1677909489','images'=>'a:1:{i:0;s:50:"202303/04/285efc2e-24d3-3383-9a03-a9ee2f8cda60.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'10','label'=>'N;','selling_point'=>'<p>23</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'20','store_id'=>'139','bloc_id'=>'38','goods_name'=>'全局名称店铺商品','category_pid'=>'8','stock'=>'100','video'=>NULL,'category_id'=>'9','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/5e534b14-9d70-31b4-986a-28cc258d95ab.png','line_price'=>'1.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>12</p>','sales_initial'=>'11','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'0','goods_costprice'=>'11.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677910465','update_time'=>'1677910465','images'=>'a:1:{i:0;s:50:"202303/04/2be27c59-bc17-35a9-8606-6662bdd1257f.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>23</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'21','store_id'=>'138','bloc_id'=>'38','goods_name'=>'商品图片显示','category_pid'=>'1','stock'=>'15','video'=>NULL,'category_id'=>'2','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/04/b2bf9346-77f5-3b09-9d58-3140c83fdb0c.png','line_price'=>'54.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>12</p>','sales_initial'=>'15','sales_actual'=>'0','goods_sort'=>'45','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'11.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1677931596','update_time'=>'1677931596','images'=>'a:1:{i:0;s:50:"202303/04/336d716b-df55-3a8f-b3cf-6406eb39a708.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'6','label'=>'s:2:"15";','selling_point'=>'<p>3</p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'22','store_id'=>'149','bloc_id'=>'51','goods_name'=>'美白修复','category_pid'=>'13','stock'=>'1','video'=>'','category_id'=>'16','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/14/c35ea405-7b33-3a67-a909-c2076ce6e1f1.png','line_price'=>'3.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'2.00','content'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230314/1678802997631934.jpg\" title=\"1678802997631934.jpg\" alt=\"3f0ffa6ef6fa9bce.jpg\"/></p>','sales_initial'=>'10','sales_actual'=>'0','goods_sort'=>'1','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'1.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1678763316','update_time'=>'1679623798','images'=>'a:3:{i:0;s:50:"202303/14/8d2afa9c-f805-37f4-b630-6daaa7b0d92a.png";i:1;s:50:"202303/14/867a9341-7e5e-305e-9d79-3df378a22348.png";i:2;s:50:"202303/14/fa8ac35b-0605-3c97-af76-21521751a2a6.png";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'14','label'=>'s:6:"热销";','selling_point'=>'高端直饮水','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'23','store_id'=>'149','bloc_id'=>'51','goods_name'=>'胶原蛋白水','category_pid'=>'15','stock'=>'-2','video'=>'','category_id'=>'0','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/14/249449b0-ee40-3584-bc2a-dd3a6072fc38.jpg','line_price'=>'3.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'1.00','content'=>'<p>1<br/></p>','sales_initial'=>'0','sales_actual'=>'0','goods_sort'=>'0','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'2.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1678800805','update_time'=>'1678844725','images'=>'a:1:{i:0;s:50:"202303/14/1ff2640e-07eb-3852-b017-ff32a1c9fc3e.jpg";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'N;','selling_point'=>'<p>2<br/></p>','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'24','store_id'=>'151','bloc_id'=>'51','goods_name'=>'336','category_pid'=>'13','stock'=>'199','video'=>'','category_id'=>'16','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/15/2db905d4-6914-36cd-bbce-a1d2c915b8f5.jpg','line_price'=>'213.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'399.00','content'=>'<p>123</p>','sales_initial'=>'156','sales_actual'=>'0','goods_sort'=>'0','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'299.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1678848768','update_time'=>'1678860424','images'=>'a:1:{i:0;s:50:"202303/15/61156511-b7ad-3a20-b8ca-979a2727d6eb.jpg";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'1','label'=>'s:3:"111";','selling_point'=>'000','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'25','store_id'=>'151','bloc_id'=>'51','goods_name'=>'12','category_pid'=>'14','stock'=>'33','video'=>'','category_id'=>'19','spec_type'=>'0','deduct_stock_type'=>'20','thumb'=>'202303/15/fe09b910-8e95-3c84-96ee-7adbe040dcf8.jpg','line_price'=>'33.00','goods_weight'=>'0','volume'=>'0.00','express_type'=>NULL,'goods_price'=>'222.00','content'=>'<p>nicai</p>','sales_initial'=>'33','sales_actual'=>'0','goods_sort'=>'3','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'33.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1678849163','update_time'=>'1678950199','images'=>'a:1:{i:0;s:50:"202303/15/6a899e9c-859f-39c5-96f0-119ebfeef04e.jpg";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'0','label'=>'s:2:"33";','selling_point'=>'213','is_check_num'=>'0','check_num'=>'1']);
        $this->insert('{{%bea_cloud_base_goods}}',['goods_id'=>'26','store_id'=>'149','bloc_id'=>'51','goods_name'=>'袋袋山泉水','category_pid'=>'20','stock'=>'52','video'=>'','category_id'=>'0','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202303/20/3db21299-803a-378c-b532-e88c3143acc3.jpg','line_price'=>'50.00','goods_weight'=>NULL,'volume'=>NULL,'express_type'=>NULL,'goods_price'=>'28.00','content'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230320/1679281162780933.jpg\" title=\"1679281162780933.jpg\" alt=\"7d2f37eb49cc55c1.jpg\"/></p>','sales_initial'=>'3','sales_actual'=>'0','goods_sort'=>'0','delivery_id'=>'0','goods_status'=>'1','goods_costprice'=>'20.00','is_delete'=>'0','goods_type'=>NULL,'wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1679281175','update_time'=>'1679627525','images'=>'a:2:{i:0;s:50:"202303/20/5f892370-3c9d-3737-8153-f79aca617038.jpg";i:1;s:50:"202303/20/08bbba98-90f8-3c35-a81c-44203188f799.jpg";}','exemption'=>NULL,'exemption_type'=>NULL,'browse'=>'3','label'=>'N;','selling_point'=>'商品买点','is_check_num'=>'0','check_num'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_base_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
