<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_base_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_base_goods}}', [
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
            'addons_id' => "int(11) NOT NULL COMMENT 'dd_diandi_cloud_addons表ID'",
            'PRIMARY KEY (`goods_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('category_id','{{%diandi_hub_base_goods}}','category_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_base_goods}}',['goods_id'=>'24','store_id'=>'80','bloc_id'=>'31','goods_name'=>'王春生009','category_pid'=>'10','stock'=>'5','video'=>NULL,'category_id'=>'12','spec_type'=>'0','deduct_stock_type'=>'10','thumb'=>'202207/07/9ab607de-f150-34c4-9b89-504057923e89.jpg','line_price'=>'6565.00','goods_weight'=>'23','volume'=>'12.00','express_type'=>NULL,'goods_price'=>'565.00','content'=>'<p>3445</p>','sales_initial'=>'65','sales_actual'=>'0','goods_sort'=>'65','delivery_id'=>'17','goods_status'=>'1','goods_costprice'=>'14.00','is_delete'=>'0','goods_type'=>'6','wxapp_id'=>'0','express_template_id'=>NULL,'create_time'=>'1665652819','update_time'=>'1665652819','images'=>'a:1:{i:0;s:50:"202207/07/6107e306-d091-32d4-a0e7-e0b421773933.jpg";}','exemption'=>'45.00','exemption_type'=>'1','browse'=>'1','label'=>'a:1:{i:0;s:1:"5";}','selling_point'=>'<p>565</p>','addons_id'=>'132']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_base_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

