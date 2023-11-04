<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_slide extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='全局配置表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_slide}}',['id'=>'6','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:34','slide'=>'202310/31/0cda887d-282e-3601-91cc-059a4d179ba0.jpg','type'=>'2']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'8','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:40','slide'=>'202310/31/f2b47f94-ebf5-3162-a8b4-2fd7df5820c5.jpg','type'=>'1']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'9','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:46','slide'=>'202310/31/a0a08403-aace-3d85-a3dc-b0c4c95e9ec7.jpg','type'=>'2']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'10','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 16:58:05','update_time'=>'2023-10-31 16:03:54','slide'=>'202310/31/2af00d91-109f-38d7-872e-557906fbb33e.jpg','type'=>'1']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'11','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-12 13:14:02','update_time'=>'2023-10-31 16:04:02','slide'=>'202310/31/60a2bc65-7bd9-36bc-b3ad-a042803cafaf.jpg','type'=>'1']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'12','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-12 13:14:23','update_time'=>'2023-10-31 16:04:09','slide'=>'202310/31/85f540b6-fc43-3e0a-8f7b-7d2a06c0f26c.jpg','type'=>'1']);
        $this->insert('{{%diandi_tea_slide}}',['id'=>'13','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-12 13:14:44','update_time'=>'2023-10-31 16:04:16','slide'=>'202310/31/07ce982b-90ee-311a-bf02-b9c594423ed8.jpg','type'=>'1']);
        
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

