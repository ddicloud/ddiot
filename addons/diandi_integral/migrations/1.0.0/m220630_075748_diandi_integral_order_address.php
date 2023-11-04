<?php

use yii\db\Migration;

class m220630_075748_diandi_integral_order_address extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'1','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'1','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608020517','update_time'=>'1608020517']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'2','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'2','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608020563','update_time'=>'1608020563']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'3','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'3','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608020860','update_time'=>'1608020860']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'4','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'4','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608020887','update_time'=>'1608020887']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'5','bloc_id'=>'8','store_id'=>'48','name'=>'春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'具体地址','order_id'=>'5','user_id'=>'14','wxapp_id'=>'0','create_time'=>'1608024659','update_time'=>'1608024659']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'6','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'6','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608025872','update_time'=>'1608025872']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'7','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'7','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608025917','update_time'=>'1608025917']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'8','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'8','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608025939','update_time'=>'1608025939']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'9','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'9','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608025988','update_time'=>'1608025988']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'10','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'10','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608026141','update_time'=>'1608026141']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'11','bloc_id'=>'8','store_id'=>'48','name'=>'曹刚','phone'=>'15094077772','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2905','detail'=>'崇业东路丰泰大厦东门','order_id'=>'11','user_id'=>'13','wxapp_id'=>'0','create_time'=>'1608027802','update_time'=>'1608027802']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'12','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'3325','city_id'=>'3592','delivery_time'=>'','region_id'=>'3606','detail'=>'13545','order_id'=>'12','user_id'=>'17','wxapp_id'=>'0','create_time'=>'1608030645','update_time'=>'1608030645']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'16','bloc_id'=>'8','store_id'=>'48','name'=>'王春生','phone'=>'17778984690','province_id'=>'2816','city_id'=>'2857','delivery_time'=>'','region_id'=>'2858','detail'=>'圆地方','order_id'=>'16','user_id'=>'60','wxapp_id'=>'0','create_time'=>'1608039522','update_time'=>'1608039522']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'17','bloc_id'=>'8','store_id'=>'48','name'=>'任卓','phone'=>'15829773213','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2905','detail'=>'永松路116号 名人居17号楼五单元','order_id'=>'17','user_id'=>'23','wxapp_id'=>'0','create_time'=>'1608039776','update_time'=>'1608039776']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'18','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'12345455666','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'18','user_id'=>'4691','wxapp_id'=>'0','create_time'=>'1648690000','update_time'=>'1648690000']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'19','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'12345455666','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'19','user_id'=>'4691','wxapp_id'=>'0','create_time'=>'1648690014','update_time'=>'1648690014']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'20','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'12345455666','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'20','user_id'=>'4691','wxapp_id'=>'0','create_time'=>'1648690043','update_time'=>'1648690043']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'21','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'12345455666','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'21','user_id'=>'4691','wxapp_id'=>'0','create_time'=>'1648690134','update_time'=>'1648690134']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'22','bloc_id'=>'33','store_id'=>'82','name'=>'2','phone'=>'12222222222','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'22','user_id'=>'58','wxapp_id'=>'0','create_time'=>'1650530252','update_time'=>'1650530252']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'23','bloc_id'=>'33','store_id'=>'82','name'=>'2','phone'=>'12222222222','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'23','user_id'=>'58','wxapp_id'=>'0','create_time'=>'1650530271','update_time'=>'1650530271']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'24','bloc_id'=>'33','store_id'=>'82','name'=>'12','phone'=>'12133565354','province_id'=>'2367','city_id'=>'2446','delivery_time'=>'','region_id'=>'2449','detail'=>'12131','order_id'=>'26','user_id'=>'58','wxapp_id'=>'0','create_time'=>'1650531617','update_time'=>'1650531617']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'25','bloc_id'=>'33','store_id'=>'82','name'=>'姚','phone'=>'13872878723','province_id'=>'19','city_id'=>'20','delivery_time'=>'','region_id'=>'27','detail'=>'诶诶','order_id'=>'28','user_id'=>'4946','wxapp_id'=>'0','create_time'=>'1650536321','update_time'=>'1650536321']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'26','bloc_id'=>'33','store_id'=>'82','name'=>'姚','phone'=>'13872878723','province_id'=>'19','city_id'=>'20','delivery_time'=>'','region_id'=>'27','detail'=>'诶诶','order_id'=>'29','user_id'=>'4946','wxapp_id'=>'0','create_time'=>'1650536427','update_time'=>'1650536427']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'27','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'30','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1650795120','update_time'=>'1650795120']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'28','bloc_id'=>'33','store_id'=>'82','name'=>'哈哈','phone'=>'13759981293','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'阿卡丽','order_id'=>'31','user_id'=>'11271','wxapp_id'=>'0','create_time'=>'1650878642','update_time'=>'1650878642']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'29','bloc_id'=>'33','store_id'=>'82','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'具体地址','order_id'=>'32','user_id'=>'4945','wxapp_id'=>'0','create_time'=>'1650924040','update_time'=>'1650924040']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'30','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'33','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1652165136','update_time'=>'1652165136']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'31','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'34','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653272607','update_time'=>'1653272607']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'32','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'35','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653272643','update_time'=>'1653272643']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'33','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'36','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653276059','update_time'=>'1653276059']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'34','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'37','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653277082','update_time'=>'1653277082']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'35','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'38','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653277466','update_time'=>'1653277466']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'36','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'39','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653277778','update_time'=>'1653277778']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'37','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'40','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653277999','update_time'=>'1653277999']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'38','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'41','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653278295','update_time'=>'1653278295']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'39','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'42','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653286522','update_time'=>'1653286522']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'40','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'43','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653356602','update_time'=>'1653356602']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'41','bloc_id'=>'30','store_id'=>'79','name'=>'12','phone'=>'13982748594','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'44','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653379608','update_time'=>'1653379608']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'42','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'45','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653379808','update_time'=>'1653379808']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'43','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'46','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653379978','update_time'=>'1653379978']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'44','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'48','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653380306','update_time'=>'1653380306']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'45','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'76','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1653545607','update_time'=>'1653545607']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'46','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'77','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1654138861','update_time'=>'1654138861']);
        $this->insert('{{%diandi_integral_order_address}}',['order_address_id'=>'47','bloc_id'=>'30','store_id'=>'79','name'=>'1','phone'=>'13891738473','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'78','user_id'=>'11254','wxapp_id'=>'0','create_time'=>'1654162017','update_time'=>'1654162017']);
        
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

