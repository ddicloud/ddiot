<?php

use yii\db\Migration;

class m220628_105253_store_label_link extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%store_label_link}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NOT NULL COMMENT '公司ID'",
            'store_id' => "int(11) NOT NULL COMMENT '商户id'",
            'label_id' => "int(11) NOT NULL COMMENT '标签ID'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store_label_link}}',['id'=>'191','bloc_id'=>'8','store_id'=>'85','label_id'=>'63','create_time'=>'1654758284','update_time'=>'1654758284']);
        $this->insert('{{%store_label_link}}',['id'=>'192','bloc_id'=>'8','store_id'=>'85','label_id'=>'62','create_time'=>'1654758284','update_time'=>'1654758284']);
        $this->insert('{{%store_label_link}}',['id'=>'193','bloc_id'=>'8','store_id'=>'85','label_id'=>'73','create_time'=>'1654758284','update_time'=>'1654758284']);
        $this->insert('{{%store_label_link}}',['id'=>'194','bloc_id'=>'31','store_id'=>'80','label_id'=>'62','create_time'=>'1654767590','update_time'=>'1654767590']);
        $this->insert('{{%store_label_link}}',['id'=>'195','bloc_id'=>'31','store_id'=>'80','label_id'=>'63','create_time'=>'1654767590','update_time'=>'1654767590']);
        $this->insert('{{%store_label_link}}',['id'=>'196','bloc_id'=>'31','store_id'=>'84','label_id'=>'75','create_time'=>'1654767599','update_time'=>'1654767599']);
        $this->insert('{{%store_label_link}}',['id'=>'197','bloc_id'=>'31','store_id'=>'84','label_id'=>'74','create_time'=>'1654767599','update_time'=>'1654767599']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store_label_link}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

