<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_basegoods_order_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_basegoods_order_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'goods_spec_id' => "int(11) NULL COMMENT '属性id'",
            'levelnum' => "int(11) NULL COMMENT '分销商等级'",
            'dislevel' => "int(11) NULL COMMENT '分销等级'",
            'member_price' => "decimal(11,2) NULL COMMENT '会员价'",
            'user_id' => "int(11) NULL COMMENT '用户id'",
            'money' => "decimal(11,2) NULL COMMENT '分销参数'",
            'price1' => "decimal(11,2) NULL COMMENT '价格1'",
            'price2' => "decimal(11,2) NULL COMMENT '价格2'",
            'price3' => "decimal(11,2) NULL COMMENT '价格3'",
            'price4' => "decimal(11,2) NULL COMMENT '价格4'",
            'price5' => "decimal(11,2) NULL COMMENT '价格5'",
            'price6' => "decimal(11,2) NULL COMMENT '价格6'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品多规格分销价格'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_hub_basegoods_order_log}}','goods_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_basegoods_order_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

