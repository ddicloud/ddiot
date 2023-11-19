<?php

use yii\db\Migration;

class m231118_154944_diandi_tea_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_slide}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'slide' => "varchar(255) NULL COMMENT '轮播图'",
            'type' => "tinyint(3) NULL COMMENT '幻灯片类型: 1.商店头部幻灯片  2.商店中间幻灯片'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='全局配置表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_slide}}',['id'=>'6','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:34','slide'=>'202310/31/0cda887d-282e-3601-91cc-059a4d179ba0.jpg','type'=>'2']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'8','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-11-17 15:29:15','slide'=>'202311/17/2696cf73-ea6e-3f17-a7d5-0e2f6434aef2.jpg','type'=>'1']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'9','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:46','slide'=>'202310/31/a0a08403-aace-3d85-a3dc-b0c4c95e9ec7.jpg','type'=>'2']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

