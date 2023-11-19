<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_order_address extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_order_address}}', [
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
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'1','bloc_id'=>'13','store_id'=>'62','name'=>'1','phone'=>'12839827837','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'1','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1657695844','update_time'=>'1657695844']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'2','bloc_id'=>'13','store_id'=>'62','name'=>'1','phone'=>'12839827837','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'2','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1657778846','update_time'=>'1657778846']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'3','bloc_id'=>'13','store_id'=>'62','name'=>'1','phone'=>'12839827837','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'1','order_id'=>'3','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1657784436','update_time'=>'1657784436']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'4','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'4','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1657838140','update_time'=>'1657838140']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'5','bloc_id'=>'13','store_id'=>'62','name'=>'测试','phone'=>'18191254388','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2906','detail'=>'test','order_id'=>'5','user_id'=>'10','wxapp_id'=>'0','create_time'=>'1658224513','update_time'=>'1658224513']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'6','bloc_id'=>'13','store_id'=>'62','name'=>'12','phone'=>'13892893892','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'6','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658389409','update_time'=>'1658389409']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'7','bloc_id'=>'13','store_id'=>'62','name'=>'12','phone'=>'13892893892','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'7','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658398650','update_time'=>'1658398650']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'8','bloc_id'=>'13','store_id'=>'62','name'=>'12','phone'=>'13892893892','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'12','order_id'=>'8','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658398689','update_time'=>'1658398689']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'9','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'9','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658816892','update_time'=>'1658816892']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'10','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'10','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658817492','update_time'=>'1658817492']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'11','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'11','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658819634','update_time'=>'1658819634']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'12','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'12','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1658820776','update_time'=>'1658820776']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'13','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'13','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658824610','update_time'=>'1658824610']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'14','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'14','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658830611','update_time'=>'1658830611']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'15','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'15','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658831775','update_time'=>'1658831775']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'16','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'16','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658832404','update_time'=>'1658832404']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'17','bloc_id'=>'13','store_id'=>'62','name'=>'姚','phone'=>'12837287382','province_id'=>'3178','city_id'=>'3202','delivery_time'=>'','region_id'=>'3204','detail'=>'12','order_id'=>'17','user_id'=>'2','wxapp_id'=>'0','create_time'=>'1658832798','update_time'=>'1658832798']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'18','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'18','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1659007408','update_time'=>'1659007408']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'19','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'39','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1659259799','update_time'=>'1659259799']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'20','bloc_id'=>'13','store_id'=>'62','name'=>'王','phone'=>'17778984690','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2902','detail'=>'丈八北路','order_id'=>'101','user_id'=>'15','wxapp_id'=>'0','create_time'=>'1659260427','update_time'=>'1659260427']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'21','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'105','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1659277496','update_time'=>'1659277496']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'22','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'108','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1659529689','update_time'=>'1659529689']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'23','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'109','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1659529714','update_time'=>'1659529714']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'24','bloc_id'=>'13','store_id'=>'62','name'=>'王','phone'=>'17778984690','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2902','detail'=>'丈八北路','order_id'=>'152','user_id'=>'15','wxapp_id'=>'0','create_time'=>'1661356656','update_time'=>'1661356656']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'25','bloc_id'=>'13','store_id'=>'62','name'=>'王','phone'=>'17778984690','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2902','detail'=>'丈八北路','order_id'=>'153','user_id'=>'15','wxapp_id'=>'0','create_time'=>'1661356717','update_time'=>'1661356717']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'26','bloc_id'=>'13','store_id'=>'62','name'=>'王','phone'=>'17778984690','province_id'=>'2898','city_id'=>'2899','delivery_time'=>'','region_id'=>'2902','detail'=>'丈八北路','order_id'=>'154','user_id'=>'15','wxapp_id'=>'0','create_time'=>'1664156945','update_time'=>'1664156945']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'27','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'155','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1664527538','update_time'=>'1664527538']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'28','bloc_id'=>'13','store_id'=>'62','name'=>'王春生','phone'=>'17778984690','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'旅途愉快','order_id'=>'156','user_id'=>'4','wxapp_id'=>'0','create_time'=>'1664527588','update_time'=>'1664527588']);
        $this->insert('{{%diandi_mall_order_address}}',['order_address_id'=>'29','bloc_id'=>'13','store_id'=>'62','name'=>'陈阳','phone'=>'18523328445','province_id'=>'801','city_id'=>'802','delivery_time'=>'','region_id'=>'813','detail'=>'。sndhdj','order_id'=>'157','user_id'=>'29','wxapp_id'=>'0','create_time'=>'1666010868','update_time'=>'1666010868']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_order_address}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

