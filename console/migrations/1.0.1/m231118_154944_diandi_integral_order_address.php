<?php

use yii\db\Migration;

class m231118_154944_diandi_integral_order_address extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_order_address}}', [
            'order_address_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'name' => "varchar(30) NOT NULL DEFAULT ''",
            'phone' => "varchar(20) NOT NULL DEFAULT ''",
            'province_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'city_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'delivery_time' => "varchar(30) NULL",
            'region_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'detail' => "varchar(255) NOT NULL DEFAULT ''",
            'order_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'user_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`order_address_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'1','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'3','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1686910005','update_time'=>'1686910005']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'2','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'4','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1686910123','update_time'=>'1686910123']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'3','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'5','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1686910236','update_time'=>'1686910236']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'4','bloc_id'=>'38','store_id'=>'138','name'=>'王春生','phone'=>'610629198811084216','province_id'=>'1','city_id'=>'110000','delivery_time'=>NULL,'region_id'=>'110101','detail'=>'具体签名','order_id'=>'6','user_id'=>'1','wxapp_id'=>'0','create_time'=>'1687136958','update_time'=>'1687136958']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'5','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'7','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687137146','update_time'=>'1687137146']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'6','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'8','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687137204','update_time'=>'1687137204']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'7','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'9','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687137459','update_time'=>'1687137459']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'8','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'10','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687137851','update_time'=>'1687137851']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'9','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'11','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687138115','update_time'=>'1687138115']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'10','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'12','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687138445','update_time'=>'1687138445']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'11','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'13','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687138603','update_time'=>'1687138603']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'12','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'14','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687139081','update_time'=>'1687139081']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'13','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'15','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687139146','update_time'=>'1687139146']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'14','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'16','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687140909','update_time'=>'1687140909']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'15','bloc_id'=>'38','store_id'=>'138','name'=>'你是你是你是','phone'=>'190099090909','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'你猜不猜','order_id'=>'17','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687141223','update_time'=>'1687141223']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'16','bloc_id'=>'38','store_id'=>'138','name'=>'里对岸','phone'=>'13309908800','province_id'=>'0','city_id'=>'0','delivery_time'=>NULL,'region_id'=>'0','detail'=>'39303','order_id'=>'18','user_id'=>'278','wxapp_id'=>'0','create_time'=>'1687170015','update_time'=>'1687170015']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'17','bloc_id'=>'91','store_id'=>'153','name'=>'王春生','phone'=>'17778984690','province_id'=>'8','city_id'=>'810000','delivery_time'=>NULL,'region_id'=>'810101','detail'=>'具体签名','order_id'=>'19','user_id'=>'1','wxapp_id'=>'0','create_time'=>'1687996529','update_time'=>'1687996529']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_order_address}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

