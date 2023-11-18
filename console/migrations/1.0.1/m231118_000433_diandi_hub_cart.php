<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_cart extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_cart}}', [
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
        $this->insert('{{%diandi_hub_cart}}',['id'=>'1','store_id'=>'82','bloc_id'=>'33','user_id'=>'58','goods_id'=>'4','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'15.00','total_price'=>'15.00','line_price'=>'12.00','create_time'=>'1650797112']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'2','store_id'=>'82','bloc_id'=>'33','user_id'=>'4946','goods_id'=>'4','spec_id'=>'','spec_val'=>'','number'=>'1','goods_price'=>'15.00','total_price'=>'15.00','line_price'=>'12.00','create_time'=>'1650799055']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'24','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'35','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'20.00','total_price'=>'20.00','line_price'=>'20.00','create_time'=>'1655295372']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'32','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'36','spec_id'=>NULL,'spec_val'=>'','number'=>'2','goods_price'=>'1.00','total_price'=>'2.00','line_price'=>'1.00','create_time'=>'1655450452']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'44','store_id'=>'80','bloc_id'=>'31','user_id'=>'12070','goods_id'=>'31','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655775653']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'43','store_id'=>'80','bloc_id'=>'31','user_id'=>'12070','goods_id'=>'24','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655775653']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'42','store_id'=>'80','bloc_id'=>'31','user_id'=>'11692','goods_id'=>'24','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655722960']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'22','store_id'=>'80','bloc_id'=>'31','user_id'=>'11625','goods_id'=>'24','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1654825898']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'41','store_id'=>'80','bloc_id'=>'31','user_id'=>'11692','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655722960']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'40','store_id'=>'80','bloc_id'=>'31','user_id'=>'11692','goods_id'=>'31','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655722960']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'39','store_id'=>'80','bloc_id'=>'31','user_id'=>'11692','goods_id'=>'35','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'20.00','total_price'=>'20.00','line_price'=>'20.00','create_time'=>'1655722960']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'38','store_id'=>'80','bloc_id'=>'31','user_id'=>'11692','goods_id'=>'26','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655722960']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'36','store_id'=>'80','bloc_id'=>'31','user_id'=>'11395','goods_id'=>'35','spec_id'=>NULL,'spec_val'=>'','number'=>'2','goods_price'=>'20.00','total_price'=>'40.00','line_price'=>'20.00','create_time'=>'1655713501']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'15','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'5','goods_price'=>'1.00','total_price'=>'5.00','line_price'=>'1.00','create_time'=>'1653525012']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'16','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'24','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1653525014']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'17','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'26','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1653525016']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'30','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'31','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655446652']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'19','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'32','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'12.00','total_price'=>'12.00','line_price'=>'120.00','create_time'=>'1653525024']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'20','store_id'=>'80','bloc_id'=>'31','user_id'=>'11625','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'12.00','total_price'=>'12.00','line_price'=>'11.00','create_time'=>'1654507930']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'25','store_id'=>'80','bloc_id'=>'31','user_id'=>'11395','goods_id'=>'31','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655365871']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'33','store_id'=>'80','bloc_id'=>'31','user_id'=>'4694','goods_id'=>'38','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'20.00','total_price'=>'20.00','line_price'=>'20.00','create_time'=>'1655450455']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'37','store_id'=>'80','bloc_id'=>'31','user_id'=>'11398','goods_id'=>'35','spec_id'=>NULL,'spec_val'=>'','number'=>'10','goods_price'=>'20.00','total_price'=>'200.00','line_price'=>'20.00','create_time'=>'1655722407']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'45','store_id'=>'80','bloc_id'=>'31','user_id'=>'12070','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655775653']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'46','store_id'=>'80','bloc_id'=>'31','user_id'=>'12070','goods_id'=>'26','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655775653']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'47','store_id'=>'80','bloc_id'=>'31','user_id'=>'12070','goods_id'=>'35','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'20.00','total_price'=>'20.00','line_price'=>'20.00','create_time'=>'1655775653']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'48','store_id'=>'80','bloc_id'=>'31','user_id'=>'11398','goods_id'=>'36','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655784655']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'49','store_id'=>'80','bloc_id'=>'31','user_id'=>'12074','goods_id'=>'24','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655869958']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'50','store_id'=>'80','bloc_id'=>'31','user_id'=>'1004','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1655869958']);
        $this->insert('{{%diandi_hub_cart}}',['id'=>'54','store_id'=>'80','bloc_id'=>'31','user_id'=>'1004','goods_id'=>'23','spec_id'=>NULL,'spec_val'=>'','number'=>'1','goods_price'=>'1.00','total_price'=>'1.00','line_price'=>'1.00','create_time'=>'1656041999']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_cart}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

