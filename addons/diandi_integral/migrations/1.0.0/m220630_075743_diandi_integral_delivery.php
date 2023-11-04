<?php

use yii\db\Migration;

class m220630_075743_diandi_integral_delivery extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_delivery}}', [
            'delivery_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(255) NOT NULL DEFAULT ''",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`delivery_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10001','store_id'=>'79','bloc_id'=>'30','name'=>'陕西区域2','sort'=>'100','create_time'=>'1648535290','update_time'=>'4294967295']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10002','store_id'=>NULL,'bloc_id'=>NULL,'name'=>'邮政','sort'=>'1','create_time'=>'1574595963','update_time'=>'1574595963']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10003','store_id'=>NULL,'bloc_id'=>NULL,'name'=>'通过运费','sort'=>'100','create_time'=>'1575992319','update_time'=>'1575992319']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10004','store_id'=>NULL,'bloc_id'=>NULL,'name'=>'突然又让他','sort'=>'5','create_time'=>'1577638173','update_time'=>'1577638066']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10005','store_id'=>NULL,'bloc_id'=>NULL,'name'=>'突然又让他','sort'=>'5','create_time'=>'1577638427','update_time'=>'1577638427']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10006','store_id'=>'79','bloc_id'=>'30','name'=>'快递1','sort'=>'1','create_time'=>'1648466214','update_time'=>'1648466214']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10008','store_id'=>'79','bloc_id'=>'30','name'=>'名称1','sort'=>'1','create_time'=>'1648466782','update_time'=>'1648466782']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10009','store_id'=>'79','bloc_id'=>'30','name'=>'12122','sort'=>'1','create_time'=>'1648521013','update_time'=>'1648520049']);
        $this->insert('{{%diandi_integral_delivery}}',['delivery_id'=>'10011','store_id'=>'79','bloc_id'=>'30','name'=>'12','sort'=>'0','create_time'=>'1648522592','update_time'=>'1648522592']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_delivery}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

