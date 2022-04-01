<?php

use yii\db\Migration;

class m220401_071131_user_address extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_address}}', [
            'address_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'name' => "varchar(30) NOT NULL DEFAULT ''",
            'phone' => "varchar(20) NOT NULL DEFAULT ''",
            'country' => "varchar(255) NULL COMMENT '国家'",
            'province_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'city_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'region_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'detail' => "varchar(255) NOT NULL DEFAULT ''",
            'user_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'is_default' => "tinyint(4) NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`address_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%user_address}}',['address_id'=>'11','name'=>'111','phone'=>'13892749572','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'818','detail'=>'222','user_id'=>'57','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630051642','update_time'=>'1630051642']);
        $this->insert('{{%user_address}}',['address_id'=>'16','name'=>'yao','phone'=>'13891749574','country'=>NULL,'province_id'=>'1709','city_id'=>'1710','region_id'=>'1723','detail'=>'2345345346','user_id'=>'58','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630061508','update_time'=>'1630061508']);
        $this->insert('{{%user_address}}',['address_id'=>'17','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630251807','update_time'=>'1630251807']);
        $this->insert('{{%user_address}}',['address_id'=>'18','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251807','update_time'=>'1630251807']);
        $this->insert('{{%user_address}}',['address_id'=>'19','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251807','update_time'=>'1630251807']);
        $this->insert('{{%user_address}}',['address_id'=>'20','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251809','update_time'=>'1630251809']);
        $this->insert('{{%user_address}}',['address_id'=>'21','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251809','update_time'=>'1630251809']);
        $this->insert('{{%user_address}}',['address_id'=>'22','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251811','update_time'=>'1630251811']);
        $this->insert('{{%user_address}}',['address_id'=>'23','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251811','update_time'=>'1630251811']);
        $this->insert('{{%user_address}}',['address_id'=>'24','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251812','update_time'=>'1630251812']);
        $this->insert('{{%user_address}}',['address_id'=>'25','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251814','update_time'=>'1630251814']);
        $this->insert('{{%user_address}}',['address_id'=>'26','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251814','update_time'=>'1630251814']);
        $this->insert('{{%user_address}}',['address_id'=>'27','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251815','update_time'=>'1630251815']);
        $this->insert('{{%user_address}}',['address_id'=>'28','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251815','update_time'=>'1630251815']);
        $this->insert('{{%user_address}}',['address_id'=>'29','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251816','update_time'=>'1630251816']);
        $this->insert('{{%user_address}}',['address_id'=>'30','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251826','update_time'=>'1630251826']);
        $this->insert('{{%user_address}}',['address_id'=>'31','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251827','update_time'=>'1630251827']);
        $this->insert('{{%user_address}}',['address_id'=>'32','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251827','update_time'=>'1630251827']);
        $this->insert('{{%user_address}}',['address_id'=>'33','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251828','update_time'=>'1630251828']);
        $this->insert('{{%user_address}}',['address_id'=>'34','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251829','update_time'=>'1630251829']);
        $this->insert('{{%user_address}}',['address_id'=>'35','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251830','update_time'=>'1630251830']);
        $this->insert('{{%user_address}}',['address_id'=>'36','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251830','update_time'=>'1630251830']);
        $this->insert('{{%user_address}}',['address_id'=>'37','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251830','update_time'=>'1630251830']);
        $this->insert('{{%user_address}}',['address_id'=>'38','name'=>'1234','phone'=>'18159543812','country'=>NULL,'province_id'=>'2670','city_id'=>'2761','region_id'=>'2766','detail'=>'i;nm','user_id'=>'71','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630251832','update_time'=>'1630251832']);
        $this->insert('{{%user_address}}',['address_id'=>'39','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630300046','update_time'=>'1630300046']);
        $this->insert('{{%user_address}}',['address_id'=>'40','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300046','update_time'=>'1630300046']);
        $this->insert('{{%user_address}}',['address_id'=>'41','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300046','update_time'=>'1630300046']);
        $this->insert('{{%user_address}}',['address_id'=>'42','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300047','update_time'=>'1630300047']);
        $this->insert('{{%user_address}}',['address_id'=>'43','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300048','update_time'=>'1630300048']);
        $this->insert('{{%user_address}}',['address_id'=>'44','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300048','update_time'=>'1630300048']);
        $this->insert('{{%user_address}}',['address_id'=>'45','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300048','update_time'=>'1630300048']);
        $this->insert('{{%user_address}}',['address_id'=>'46','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300048','update_time'=>'1630300048']);
        $this->insert('{{%user_address}}',['address_id'=>'47','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300049','update_time'=>'1630300049']);
        $this->insert('{{%user_address}}',['address_id'=>'48','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300055','update_time'=>'1630300055']);
        $this->insert('{{%user_address}}',['address_id'=>'49','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300055','update_time'=>'1630300055']);
        $this->insert('{{%user_address}}',['address_id'=>'50','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300055','update_time'=>'1630300055']);
        $this->insert('{{%user_address}}',['address_id'=>'51','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300056','update_time'=>'1630300056']);
        $this->insert('{{%user_address}}',['address_id'=>'52','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300056','update_time'=>'1630300056']);
        $this->insert('{{%user_address}}',['address_id'=>'53','name'=>'刚刚好','phone'=>'11223344556','country'=>NULL,'province_id'=>'3716','city_id'=>'3717','region_id'=>'3718','detail'=>'亲亲亲亲亲','user_id'=>'70','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300056','update_time'=>'1630300056']);
        $this->insert('{{%user_address}}',['address_id'=>'54','name'=>'wu','phone'=>'13677887766','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2709','detail'=>'速度发顺丰发','user_id'=>'69','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630300701','update_time'=>'1630300701']);
        $this->insert('{{%user_address}}',['address_id'=>'55','name'=>'wu','phone'=>'13677887766','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2709','detail'=>'速度发顺丰发','user_id'=>'69','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300707','update_time'=>'1630300707']);
        $this->insert('{{%user_address}}',['address_id'=>'56','name'=>'wu','phone'=>'13677887766','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2709','detail'=>'速度发顺丰发','user_id'=>'69','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630300773','update_time'=>'1630300773']);
        $this->insert('{{%user_address}}',['address_id'=>'57','name'=>'齐优享','phone'=>'13891749571','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2711','detail'=>'润体乳','user_id'=>'68','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630303507','update_time'=>'1630303507']);
        $this->insert('{{%user_address}}',['address_id'=>'58','name'=>'齐优享','phone'=>'13891749571','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2711','detail'=>'润体乳','user_id'=>'68','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630303512','update_time'=>'1630303512']);
        $this->insert('{{%user_address}}',['address_id'=>'59','name'=>'齐优享','phone'=>'13891749571','country'=>NULL,'province_id'=>'2670','city_id'=>'2706','region_id'=>'2711','detail'=>'润体乳','user_id'=>'68','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630303525','update_time'=>'1630303525']);
        $this->insert('{{%user_address}}',['address_id'=>'60','name'=>'111','phone'=>'13891749570','country'=>NULL,'province_id'=>'0','city_id'=>'0','region_id'=>'0','detail'=>'qqqqqqqV Bw','user_id'=>'72','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1630310527','update_time'=>'1630310527']);
        $this->insert('{{%user_address}}',['address_id'=>'61','name'=>'111','phone'=>'13891749570','country'=>NULL,'province_id'=>'0','city_id'=>'0','region_id'=>'0','detail'=>'qqqqqqqV Bw','user_id'=>'72','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1630310532','update_time'=>'1630310532']);
        $this->insert('{{%user_address}}',['address_id'=>'62','name'=>'12','phone'=>'12345455666','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'813','detail'=>'12','user_id'=>'4691','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1648689882','update_time'=>'1648689882']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_address}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

