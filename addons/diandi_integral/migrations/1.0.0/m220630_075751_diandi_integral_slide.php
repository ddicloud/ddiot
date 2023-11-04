<?php

use yii\db\Migration;

class m220630_075751_diandi_integral_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_slide}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'slide' => "varchar(255) NULL COMMENT '轮播图'",
            'type' => "tinyint(3) NULL DEFAULT '1' COMMENT '幻灯片类型: 1.商店头部幻灯片  2.商店中间幻灯片'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='全局配置表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_slide}}',['id'=>'7','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-04-06 10:33:45','update_time'=>'2022-06-07 18:48:16','slide'=>'202206/02/40090ce6-798d-3ba6-9cfd-4145d39f59af.jpg','type'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

