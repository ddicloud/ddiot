<?php

use yii\db\Migration;

class m221102_024927_queue extends Migration
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
        $this->insert('{{%queue}}',['id'=>'18','channel'=>'queue','job'=>'O:44:"addons\diandi_switch\services\jobs\SwitchJob":6:{s:11:"ext_room_id";s:1:"5";s:11:"switch_type";s:1:"1";s:12:"ext_event_id";i:970;s:7:"bloc_id";N;s:8:"store_id";N;s:6:"addons";N;}','pushed_at'=>'1666868316','ttr'=>'300','delay'=>'7587','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'19','channel'=>'queue','job'=>'O:44:"addons\diandi_switch\services\jobs\SwitchJob":6:{s:11:"ext_room_id";s:1:"5";s:11:"switch_type";s:1:"1";s:12:"ext_event_id";i:970;s:7:"bloc_id";N;s:8:"store_id";N;s:6:"addons";N;}','pushed_at'=>'1666868316','ttr'=>'300','delay'=>'7887','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'20','channel'=>'queue','job'=>'O:44:"addons\diandi_switch\services\jobs\SwitchJob":6:{s:11:"ext_room_id";s:1:"5";s:11:"switch_type";s:1:"1";s:12:"ext_event_id";i:970;s:7:"bloc_id";N;s:8:"store_id";N;s:6:"addons";N;}','pushed_at'=>'1666868316','ttr'=>'300','delay'=>'8187','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'21','channel'=>'queue','job'=>'O:44:"addons\diandi_switch\services\jobs\SwitchJob":6:{s:11:"ext_room_id";s:1:"5";s:11:"switch_type";s:1:"1";s:12:"ext_event_id";i:970;s:7:"bloc_id";N;s:8:"store_id";N;s:6:"addons";N;}','pushed_at'=>'1666868316','ttr'=>'300','delay'=>'8487','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        $this->insert('{{%queue}}',['id'=>'22','channel'=>'queue','job'=>'O:44:"addons\diandi_switch\services\jobs\SwitchJob":6:{s:11:"ext_room_id";s:1:"5";s:11:"switch_type";s:1:"1";s:12:"ext_event_id";i:970;s:7:"bloc_id";N;s:8:"store_id";N;s:6:"addons";N;}','pushed_at'=>'1666868317','ttr'=>'300','delay'=>'8787','priority'=>'1024','reserved_at'=>NULL,'attempt'=>NULL,'done_at'=>NULL]);
        
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

