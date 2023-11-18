<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_cart extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_cart}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'user_id' => "int(11) NULL COMMENT '用户id'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'spec_id' => "varchar(30) NULL DEFAULT '0' COMMENT '规格组合id'",
            'spec_val' => "varchar(30) NULL COMMENT '规格组合名称'",
            'number' => "int(11) NOT NULL DEFAULT '0' COMMENT '数量'",
            'goods_price' => "decimal(10,2) NOT NULL",
            'total_price' => "decimal(10,2) NULL COMMENT '总价格'",
            'line_price' => "decimal(10,2) NOT NULL",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='购物车'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_cart}}',['id'=>'16','store_id'=>'62','bloc_id'=>'13','user_id'=>'15','goods_id'=>'4','spec_id'=>'','spec_val'=>'','number'=>'30','goods_price'=>'399.00','total_price'=>'11970.00','line_price'=>'399.00','create_time'=>'1661356692']);
        $this->insert('{{%diandi_mall_cart}}',['id'=>'14','store_id'=>'62','bloc_id'=>'13','user_id'=>'2','goods_id'=>'1','spec_id'=>'2','spec_val'=>'12','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1658824600']);
        $this->insert('{{%diandi_mall_cart}}',['id'=>'15','store_id'=>'62','bloc_id'=>'13','user_id'=>'15','goods_id'=>'5','spec_id'=>'','spec_val'=>'','number'=>'10','goods_price'=>'499.00','total_price'=>'4990.00','line_price'=>'1499.00','create_time'=>'1659260372']);
        $this->insert('{{%diandi_mall_cart}}',['id'=>'13','store_id'=>'62','bloc_id'=>'13','user_id'=>'2','goods_id'=>'5','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'12.00','total_price'=>'12.00','line_price'=>'23.00','create_time'=>'1658738748']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_cart}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

