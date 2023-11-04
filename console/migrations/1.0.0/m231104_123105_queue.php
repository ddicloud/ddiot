<?php

use yii\db\Migration;

class m231104_123105_queue extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
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

