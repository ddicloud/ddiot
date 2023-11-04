<?php

use yii\db\Migration;

class m231104_123106_user_address extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%user_address}}',['address_id'=>'2','name'=>'王春生','phone'=>'17778984690','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'813','detail'=>'旅途愉快','user_id'=>'4','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1657838138','update_time'=>'1657838138']);
        $this->insert('{{%user_address}}',['address_id'=>'3','name'=>'测试','phone'=>'18191254388','country'=>NULL,'province_id'=>'2898','city_id'=>'2899','region_id'=>'2906','detail'=>'test','user_id'=>'10','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1658224509','update_time'=>'1658224509']);
        $this->insert('{{%user_address}}',['address_id'=>'11','name'=>'姚','phone'=>'12837287382','country'=>NULL,'province_id'=>'3178','city_id'=>'3202','region_id'=>'3204','detail'=>'12','user_id'=>'2','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1658742848','update_time'=>'1658742848']);
        $this->insert('{{%user_address}}',['address_id'=>'12','name'=>'王','phone'=>'17778984690','country'=>NULL,'province_id'=>'2898','city_id'=>'2899','region_id'=>'2902','detail'=>'丈八北路','user_id'=>'15','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1659259649','update_time'=>'1659259649']);
        $this->insert('{{%user_address}}',['address_id'=>'13','name'=>'陈阳','phone'=>'18523328445','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'813','detail'=>'。sndhdj','user_id'=>'29','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1666010861','update_time'=>'1666010861']);
        $this->insert('{{%user_address}}',['address_id'=>'29','name'=>'王二麻子','phone'=>'19099008989','country'=>NULL,'province_id'=>'0','city_id'=>'0','region_id'=>'0','detail'=>'详细测试地址','user_id'=>'278','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1686727847','update_time'=>'1686727847']);
        $this->insert('{{%user_address}}',['address_id'=>'31','name'=>'里对岸','phone'=>'13309908800','country'=>NULL,'province_id'=>'0','city_id'=>'0','region_id'=>'0','detail'=>'39303','user_id'=>'278','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1686824484','update_time'=>'1686824484']);
        $this->insert('{{%user_address}}',['address_id'=>'32','name'=>'123','phone'=>'12313','country'=>NULL,'province_id'=>'0','city_id'=>'0','region_id'=>'0','detail'=>'12313','user_id'=>'278','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1686824728','update_time'=>'1686824728']);
        $this->insert('{{%user_address}}',['address_id'=>'33','name'=>'王春生','phone'=>'17778984690','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'813','detail'=>'具体签名途径','user_id'=>'1','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1687136954','update_time'=>'1687136954']);
        $this->insert('{{%user_address}}',['address_id'=>'38','name'=>'八天霸天天虎','phone'=>'159159159','country'=>NULL,'province_id'=>'19','city_id'=>'20','region_id'=>'27','detail'=>'89号楼','user_id'=>'270','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1688091499','update_time'=>'1688091499']);
        $this->insert('{{%user_address}}',['address_id'=>'39','name'=>'擎天柱卡布达','phone'=>'741852963','country'=>NULL,'province_id'=>'2898','city_id'=>'2899','region_id'=>'2903','detail'=>'齐齐哈尔卡布达','user_id'=>'270','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1688091513','update_time'=>'1688091513']);
        $this->insert('{{%user_address}}',['address_id'=>'40','name'=>'嘻嘻哈哈中国人','phone'=>'12345678977','country'=>NULL,'province_id'=>'3738','city_id'=>'3745','region_id'=>'3746','detail'=>'M78星云星云星云','user_id'=>'270','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1688113042','update_time'=>'1688113042']);
        $this->insert('{{%user_address}}',['address_id'=>'41','name'=>'wyf坤坤','phone'=>'1111595955','country'=>NULL,'province_id'=>'801','city_id'=>'802','region_id'=>'813','detail'=>'1322232号','user_id'=>'270','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1688120376','update_time'=>'1688120376']);
        $this->insert('{{%user_address}}',['address_id'=>'43','name'=>'测试','phone'=>'1459875986','country'=>NULL,'province_id'=>'3178','city_id'=>'3202','region_id'=>'3204','detail'=>'嘻嘻哈哈123','user_id'=>'270','wxapp_id'=>'0','is_default'=>'0','create_time'=>'1688352397','update_time'=>'1688352397']);
        $this->insert('{{%user_address}}',['address_id'=>'45','name'=>'机器人','phone'=>'18812345667','country'=>NULL,'province_id'=>'1','city_id'=>'2','region_id'=>'3','detail'=>'科技有限公司股份转让费了？','user_id'=>'293','wxapp_id'=>'0','is_default'=>'1','create_time'=>'1688355427','update_time'=>'1688355427']);
        
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

