<?php

use yii\db\Migration;

class m231118_000438_store_label extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%store_label}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NOT NULL COMMENT '公司ID'",
            'store_id' => "int(11) NOT NULL COMMENT '商户id'",
            'name' => "varchar(255) NULL COMMENT '标签名称'",
            'thumb' => "varchar(255) NULL COMMENT '标签图片'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'color' => "varchar(30) NULL COMMENT '颜色'",
            'is_show' => "int(11) NOT NULL COMMENT '是否显示'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store_label}}',['id'=>'62','bloc_id'=>'8','store_id'=>'48','name'=>'标签1','thumb'=>'','displayorder'=>NULL,'color'=>'','is_show'=>'0','create_time'=>NULL,'update_time'=>'1610819523']);
        $this->insert('{{%store_label}}',['id'=>'63','bloc_id'=>'0','store_id'=>'49','name'=>'标签2','thumb'=>NULL,'displayorder'=>NULL,'color'=>NULL,'is_show'=>'0','create_time'=>NULL,'update_time'=>NULL]);
        $this->insert('{{%store_label}}',['id'=>'64','bloc_id'=>'0','store_id'=>'51','name'=>'3','thumb'=>NULL,'displayorder'=>NULL,'color'=>NULL,'is_show'=>'0','create_time'=>NULL,'update_time'=>NULL]);
        $this->insert('{{%store_label}}',['id'=>'65','bloc_id'=>'0','store_id'=>'53','name'=>'标签4','thumb'=>NULL,'displayorder'=>NULL,'color'=>NULL,'is_show'=>'0','create_time'=>NULL,'update_time'=>NULL]);
        $this->insert('{{%store_label}}',['id'=>'66','bloc_id'=>'0','store_id'=>'54','name'=>'标签5','thumb'=>NULL,'displayorder'=>NULL,'color'=>NULL,'is_show'=>'0','create_time'=>NULL,'update_time'=>NULL]);
        $this->insert('{{%store_label}}',['id'=>'67','bloc_id'=>'0','store_id'=>'55','name'=>'标签6','thumb'=>NULL,'displayorder'=>NULL,'color'=>NULL,'is_show'=>'0','create_time'=>NULL,'update_time'=>NULL]);
        $this->insert('{{%store_label}}',['id'=>'73','bloc_id'=>'8','store_id'=>'48','name'=>'金牌商家','thumb'=>'202101/17/00cdc9a4-daff-3794-bf0c-74325f79ff77.png','displayorder'=>'1','color'=>'23','is_show'=>'1','create_time'=>'1610851509','update_time'=>'1610851509']);
        $this->insert('{{%store_label}}',['id'=>'74','bloc_id'=>'0','store_id'=>'0','name'=>'标签名称','thumb'=>'http://www.ai.com/attachment/202106/10/f3a27414-2663-362e-b23e-8bc5ffcd9762.jpg','displayorder'=>'4','color'=>'','is_show'=>'0','create_time'=>'1623291812','update_time'=>'1623307418']);
        $this->insert('{{%store_label}}',['id'=>'75','bloc_id'=>'0','store_id'=>'0','name'=>'测试名称','thumb'=>'http://www.ai.com/attachment/202106/10/ddf68894-007c-32c1-878f-c569f5ceab1e.jpg','displayorder'=>'1','color'=>NULL,'is_show'=>'0','create_time'=>'1623291971','update_time'=>'1623291971']);
        $this->insert('{{%store_label}}',['id'=>'76','bloc_id'=>'8','store_id'=>'58','name'=>'111','thumb'=>'http://www.ai.com/attachment/202106/15/1105555b-43a0-3bfb-9961-d0cb9729a3ac.jpg','displayorder'=>'1','color'=>NULL,'is_show'=>'0','create_time'=>'1623750928','update_time'=>'1623750928']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store_label}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

