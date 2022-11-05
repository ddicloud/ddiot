<?php

use yii\db\Migration;

class m221105_101636_bloc_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NOT NULL COMMENT '公司ID'",
            'global_bloc_id' => "int(11) NULL COMMENT '集团ID'",
            'name' => "varchar(255) NULL COMMENT '等级名称'",
            'thumb' => "varchar(255) NULL COMMENT '等级图片'",
            'level_num' => "int(11) NULL COMMENT '等级'",
            'extra' => "varchar(255) NULL COMMENT '等级扩展字段'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bloc_level}}',['id'=>'85','bloc_id'=>'10','global_bloc_id'=>'8','name'=>'10','thumb'=>'http://www.ai.com/attachment/202106/04/1e70bb8c-edd1-310d-93a4-3d247edab5cc.jpg','level_num'=>'6','extra'=>NULL,'create_time'=>'1622776872','update_time'=>'1622776872']);
        $this->insert('{{%bloc_level}}',['id'=>'86','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'美年达','thumb'=>'http://www.ai.com/attachment/202106/04/0e7ca257-309c-30a1-8108-4b19a556400c.jpg','level_num'=>'10','extra'=>NULL,'create_time'=>'1622777741','update_time'=>'1622777741']);
        $this->insert('{{%bloc_level}}',['id'=>'87','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'测试','thumb'=>'http://www.ai.com/attachment/202106/04/c0b42a71-5302-34e6-8bcd-8c406024abdb.jpg','level_num'=>'4','extra'=>NULL,'create_time'=>'1622777935','update_time'=>'1622777935']);
        $this->insert('{{%bloc_level}}',['id'=>'88','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'等级测试','thumb'=>NULL,'level_num'=>'2','extra'=>NULL,'create_time'=>'1622779279','update_time'=>'1622779279']);
        $this->insert('{{%bloc_level}}',['id'=>'89','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'等级二','thumb'=>NULL,'level_num'=>'2','extra'=>NULL,'create_time'=>'1622779300','update_time'=>'1622779300']);
        $this->insert('{{%bloc_level}}',['id'=>'90','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'等级二3','thumb'=>NULL,'level_num'=>'2','extra'=>NULL,'create_time'=>'1622779334','update_time'=>'1622779334']);
        $this->insert('{{%bloc_level}}',['id'=>'91','bloc_id'=>'11','global_bloc_id'=>'8','name'=>'等级二','thumb'=>NULL,'level_num'=>'2','extra'=>NULL,'create_time'=>'1622780169','update_time'=>'1622780169']);
        $this->insert('{{%bloc_level}}',['id'=>'92','bloc_id'=>'8','global_bloc_id'=>'10','name'=>'等级AAA1','thumb'=>'http://www.ai.com/attachment/202106/04/d615b7ef-e6b7-32d1-a156-e19f3a1afba5.jpg','level_num'=>'2','extra'=>'','create_time'=>'1622785506','update_time'=>'1622785744']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

