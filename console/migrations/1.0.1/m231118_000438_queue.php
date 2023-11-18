<?php

use yii\db\Migration;

class m231118_000438_queue extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%queue}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'channel' => "varchar(255) NOT NULL",
            'job' => "blob NOT NULL",
            'pushed_at' => "int(11) NOT NULL",
            'ttr' => "int(11) NOT NULL",
            'delay' => "int(11) NOT NULL DEFAULT '0'",
            'priority' => "int(11) unsigned NOT NULL DEFAULT '1024'",
            'reserved_at' => "int(11) NULL",
            'attempt' => "int(11) NULL",
            'done_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('channel','{{%queue}}','channel',0);
        $this->createIndex('reserved_at','{{%queue}}','reserved_at',0);
        $this->createIndex('priority','{{%queue}}','priority',0);
        
        
        /* 表数据 */
        $this->insert('{{%queue}}',['id'=>'1','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:498;}','pushed_at'=>'1698742172','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'2','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:499;}','pushed_at'=>'1698742407','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'3','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:500;}','pushed_at'=>'1698742433','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'4','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:501;}','pushed_at'=>'1698742577','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'5','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:502;}','pushed_at'=>'1698756435','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'6','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:503;}','pushed_at'=>'1698757365','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'7','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:504;}','pushed_at'=>'1698860072','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'8','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:505;}','pushed_at'=>'1698971939','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'9','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:506;}','pushed_at'=>'1699147335','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'10','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:507;}','pushed_at'=>'1699152142','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'11','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:508;}','pushed_at'=>'1699152152','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'12','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:0;}','pushed_at'=>'1699195572','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'13','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:509;}','pushed_at'=>'1699230100','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'14','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:510;}','pushed_at'=>'1699231319','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'15','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:511;}','pushed_at'=>'1699231378','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'16','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:512;}','pushed_at'=>'1699231392','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'17','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:513;}','pushed_at'=>'1699285238','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'18','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:514;}','pushed_at'=>'1699840120','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'19','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:515;}','pushed_at'=>'1699896243','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'20','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:516;}','pushed_at'=>'1700206041','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'21','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:517;}','pushed_at'=>'1700206049','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'22','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:518;}','pushed_at'=>'1700206112','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'23','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:519;}','pushed_at'=>'1700206225','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'24','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:520;}','pushed_at'=>'1700206243','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'25','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:521;}','pushed_at'=>'1700206480','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'26','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:522;}','pushed_at'=>'1700206619','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'27','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:523;}','pushed_at'=>'1700206636','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'28','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:524;}','pushed_at'=>'1700206771','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'29','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:525;}','pushed_at'=>'1700206889','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'30','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:526;}','pushed_at'=>'1700206936','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'31','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:527;}','pushed_at'=>'1700207063','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'32','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:528;}','pushed_at'=>'1700207067','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'33','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:529;}','pushed_at'=>'1700207092','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'34','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:530;}','pushed_at'=>'1700207123','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'35','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:531;}','pushed_at'=>'1700207315','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'36','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:1;}','pushed_at'=>'1700207726','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'37','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:2;}','pushed_at'=>'1700207842','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'38','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:3;}','pushed_at'=>'1700208246','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'39','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:4;}','pushed_at'=>'1700208476','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'40','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:5;}','pushed_at'=>'1700209037','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'41','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:6;}','pushed_at'=>'1700209079','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'42','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:7;}','pushed_at'=>'1700209515','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'43','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:8;}','pushed_at'=>'1700209953','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'44','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:9;}','pushed_at'=>'1700210494','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'45','channel'=>'queue','job'=>'O:40:"addons\diandi_tea\services\jobs\Orderobs":1:{s:8:"order_id";i:10;}','pushed_at'=>'1700241818','ttr'=>'300','delay'=>'300','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%queue}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

