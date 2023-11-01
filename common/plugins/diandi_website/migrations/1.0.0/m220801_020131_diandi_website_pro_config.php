<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_config}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'image_a' => "varchar(255) NULL COMMENT '公众号演示二维码'",
            'image_b' => "varchar(255) NULL COMMENT '商城二维码'",
            'image_c' => "varchar(255) NULL COMMENT '官方公众号二维码'",
            'image_d' => "varchar(255) NULL COMMENT '官方商城二维码'",
            'price_system' => "text NULL COMMENT '价格体系'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品全局配置'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'1','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'3','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'4','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'5','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'6','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'7','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'8','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'9','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'10','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'11','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'12','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'13','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'14','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'15','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'16','store_id'=>'75','bloc_id'=>'27','create_time'=>'','update_time'=>'','image_a'=>'','image_b'=>NULL,'image_c'=>NULL,'image_d'=>NULL,'price_system'=>NULL]);
        $this->insert('{{%diandi_website_pro_config}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 14:21:00','update_time'=>'2022-06-07 14:21:00','image_a'=>'202206/07/de359389-0d2e-312c-b4e7-1c2897cacc94.png','image_b'=>'202206/07/af4415dd-51fe-3b77-b1f4-5f6d18b8963b.png','image_c'=>'202206/07/3a600a2d-ca28-3a8c-b9c3-49d3d649e323.png','image_d'=>'202206/07/8ccef190-04d9-3caf-96dd-85f050935478.png','price_system'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

