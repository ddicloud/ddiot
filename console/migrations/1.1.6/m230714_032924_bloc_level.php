<?php

use yii\db\Migration;

class m230714_032924_bloc_level extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bloc_level}}',['id'=>'95','bloc_id'=>'38','global_bloc_id'=>'0','name'=>'省代','thumb'=>'202303/10/324d4e6c-30c5-3e6b-b714-8f9dea593388.png','level_num'=>'1','extra'=>NULL,'create_time'=>'1678438488','update_time'=>'1678438488']);
        
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

