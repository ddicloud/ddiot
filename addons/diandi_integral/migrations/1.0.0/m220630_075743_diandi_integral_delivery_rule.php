<?php

use yii\db\Migration;

class m220630_075743_diandi_integral_delivery_rule extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_delivery_rule}}', [
            'rule_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'delivery_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'region' => "text NOT NULL",
            'first' => "double unsigned NOT NULL DEFAULT '0'",
            'first_fee' => "decimal(10,2) unsigned NOT NULL",
            'additional' => "double unsigned NOT NULL DEFAULT '0'",
            'additional_fee' => "decimal(10,2) unsigned NOT NULL",
            'create_time' => "int(11) unsigned NOT NULL",
            'PRIMARY KEY (`rule_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_delivery_rule}}',['rule_id'=>'10006','bloc_id'=>'30','store_id'=>'79','delivery_id'=>'10004','region'=>'1,2,3,6,14,17,16,18,15,10,13,5,8,7,4,11,9,12','first'=>'444','first_fee'=>'444.00','additional'=>'44','additional_fee'=>'44.00','create_time'=>'1648543446']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_delivery_rule}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

