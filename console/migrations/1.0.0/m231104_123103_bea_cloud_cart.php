<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_cart extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_cart}}', [
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
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='购物车'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_cart}}',['id'=>'115','store_id'=>'151','bloc_id'=>'51','user_id'=>'125','goods_id'=>'24','spec_id'=>'','spec_val'=>'','number'=>'2','goods_price'=>'399.00','total_price'=>'798.00','line_price'=>'213.00','create_time'=>'1679293511']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'125','store_id'=>'139','bloc_id'=>'38','user_id'=>'131','goods_id'=>'19','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1679581238']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'123','store_id'=>'139','bloc_id'=>'38','user_id'=>'129','goods_id'=>'19','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1679539768']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'114','store_id'=>'149','bloc_id'=>'51','user_id'=>'125','goods_id'=>'26','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'28.00','total_price'=>'28.00','line_price'=>'50.00','create_time'=>'1679293503']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'99','store_id'=>'62','bloc_id'=>'13','user_id'=>'84','goods_id'=>'8','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'5999.00','total_price'=>'5999.00','line_price'=>'5999.00','create_time'=>'1678182723']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'122','store_id'=>'139','bloc_id'=>'38','user_id'=>'127','goods_id'=>'19','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1679472211']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'102','store_id'=>'62','bloc_id'=>'13','user_id'=>'83','goods_id'=>'4','spec_id'=>'','spec_val'=>'','number'=>'4','goods_price'=>'399.00','total_price'=>'1596.00','line_price'=>'399.00','create_time'=>'1678374401']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'101','store_id'=>'139','bloc_id'=>'38','user_id'=>'83','goods_id'=>'19','spec_id'=>'','spec_val'=>'','number'=>'2','goods_price'=>'1.00','total_price'=>'2.00','line_price'=>'1.00','create_time'=>'1678365403']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'100','store_id'=>'62','bloc_id'=>'13','user_id'=>'83','goods_id'=>'1','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1678365397']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'98','store_id'=>'62','bloc_id'=>'13','user_id'=>'84','goods_id'=>'5','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'499.00','total_price'=>'499.00','line_price'=>'1499.00','create_time'=>'1678182721']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'121','store_id'=>'149','bloc_id'=>'51','user_id'=>'123','goods_id'=>'26','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'28.00','total_price'=>'28.00','line_price'=>'50.00','create_time'=>'1679451616']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'97','store_id'=>'62','bloc_id'=>'13','user_id'=>'84','goods_id'=>'4','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'399.00','total_price'=>'399.00','line_price'=>'399.00','create_time'=>'1678182720']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'96','store_id'=>'62','bloc_id'=>'13','user_id'=>'84','goods_id'=>'1','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1678182719']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'116','store_id'=>'151','bloc_id'=>'51','user_id'=>'125','goods_id'=>'24','spec_id'=>'','spec_val'=>'','number'=>'2','goods_price'=>'399.00','total_price'=>'798.00','line_price'=>'213.00','create_time'=>'1679293511']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'117','store_id'=>'149','bloc_id'=>'51','user_id'=>'125','goods_id'=>'22','spec_id'=>'','spec_val'=>'','number'=>'3','goods_price'=>'2.00','total_price'=>'6.00','line_price'=>'3.00','create_time'=>'1679293511']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'118','store_id'=>'151','bloc_id'=>'51','user_id'=>'125','goods_id'=>'25','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'222.00','total_price'=>'222.00','line_price'=>'33.00','create_time'=>'1679293525']);
        $this->insert('{{%bea_cloud_cart}}',['id'=>'120','store_id'=>'149','bloc_id'=>'51','user_id'=>'90','goods_id'=>'26','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'28.00','total_price'=>'28.00','line_price'=>'50.00','create_time'=>'1679364997']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_cart}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

