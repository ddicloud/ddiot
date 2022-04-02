<?php

use yii\db\Migration;

class m220401_071131_c_auto_8 extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%c_auto_8}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'qishu' => "bigint(6) NOT NULL COMMENT '开奖期数'",
            'datetime' => "datetime NOT NULL COMMENT '开奖时间'",
            'ok' => "int(1) NOT NULL DEFAULT '0' COMMENT '1=已开奖'",
            'type' => "int(11) NOT NULL DEFAULT '24'",
            'ball_1' => "int(2) NOT NULL COMMENT '号码1'",
            'ball_2' => "int(2) NOT NULL COMMENT '号码2'",
            'ball_3' => "int(2) NOT NULL COMMENT '号码3'",
            'ball_4' => "int(2) NOT NULL COMMENT '号码4'",
            'ball_5' => "int(2) NOT NULL COMMENT '号码5'",
            'ball_6' => "int(2) NOT NULL COMMENT '号码6'",
            'ball_7' => "int(2) NOT NULL COMMENT '号码7'",
            'ball_8' => "int(2) NOT NULL COMMENT '号码8'",
            'ball_9' => "int(2) NOT NULL COMMENT '号码9'",
            'ball_10' => "int(2) NOT NULL COMMENT '号码10'",
            'ball_11' => "int(2) NOT NULL",
            'ball_12' => "int(2) NOT NULL",
            'ball_13' => "int(2) NOT NULL",
            'ball_14' => "int(2) NOT NULL",
            'ball_15' => "int(2) NOT NULL",
            'ball_16' => "int(2) NOT NULL",
            'ball_17' => "int(2) NOT NULL",
            'ball_18' => "int(2) NOT NULL",
            'ball_19' => "int(2) NOT NULL",
            'ball_20' => "int(2) NOT NULL",
            'yl' => "int(2) NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='老幸运飞艇'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%c_auto_8}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

