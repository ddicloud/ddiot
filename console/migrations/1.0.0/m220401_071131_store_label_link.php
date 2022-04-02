<?php

use yii\db\Migration;

class m220401_071131_store_label_link extends Migration
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
            'label_id' => "int(11) NULL COMMENT '标签ID'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store_label_link}}',['id'=>'73','bloc_id'=>'8','store_id'=>'62','label_id'=>'63','create_time'=>'1610822721','update_time'=>'1610822721']);
        $this->insert('{{%store_label_link}}',['id'=>'74','bloc_id'=>'8','store_id'=>'62','label_id'=>'64','create_time'=>'1610822721','update_time'=>'1610822721']);
        $this->insert('{{%store_label_link}}',['id'=>'75','bloc_id'=>'8','store_id'=>'62','label_id'=>'67','create_time'=>'1610822721','update_time'=>'1610822721']);
        $this->insert('{{%store_label_link}}',['id'=>'79','bloc_id'=>'8','store_id'=>'63','label_id'=>'64','create_time'=>'1610856390','update_time'=>'1610856390']);
        $this->insert('{{%store_label_link}}',['id'=>'80','bloc_id'=>'8','store_id'=>'63','label_id'=>'65','create_time'=>'1610856390','update_time'=>'1610856390']);
        $this->insert('{{%store_label_link}}',['id'=>'81','bloc_id'=>'8','store_id'=>'63','label_id'=>'66','create_time'=>'1610856390','update_time'=>'1610856390']);
        $this->insert('{{%store_label_link}}',['id'=>'83','bloc_id'=>'11','store_id'=>'64','label_id'=>'64','create_time'=>'1610857089','update_time'=>'1610857089']);
        $this->insert('{{%store_label_link}}',['id'=>'84','bloc_id'=>'11','store_id'=>'64','label_id'=>'66','create_time'=>'1610857089','update_time'=>'1610857089']);
        $this->insert('{{%store_label_link}}',['id'=>'85','bloc_id'=>'8','store_id'=>'65','label_id'=>'62','create_time'=>'1610857170','update_time'=>'1610857170']);
        $this->insert('{{%store_label_link}}',['id'=>'86','bloc_id'=>'8','store_id'=>'65','label_id'=>'63','create_time'=>'1610857170','update_time'=>'1610857170']);
        $this->insert('{{%store_label_link}}',['id'=>'87','bloc_id'=>'8','store_id'=>'65','label_id'=>'66','create_time'=>'1610857170','update_time'=>'1610857170']);
        $this->insert('{{%store_label_link}}',['id'=>'93','bloc_id'=>'11','store_id'=>'55','label_id'=>'65','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'94','bloc_id'=>'11','store_id'=>'55','label_id'=>'67','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'95','bloc_id'=>'11','store_id'=>'55','label_id'=>'73','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'96','bloc_id'=>'12','store_id'=>'66','label_id'=>'63','create_time'=>'1616639147','update_time'=>'1616639147']);
        $this->insert('{{%store_label_link}}',['id'=>'97','bloc_id'=>'12','store_id'=>'66','label_id'=>'66','create_time'=>'1616639147','update_time'=>'1616639147']);
        $this->insert('{{%store_label_link}}',['id'=>'98','bloc_id'=>'12','store_id'=>'66','label_id'=>'73','create_time'=>'1616639147','update_time'=>'1616639147']);
        $this->insert('{{%store_label_link}}',['id'=>'125','bloc_id'=>'8','store_id'=>'0','label_id'=>'64','create_time'=>'1621818439','update_time'=>'1621818439']);
        $this->insert('{{%store_label_link}}',['id'=>'126','bloc_id'=>'8','store_id'=>'0','label_id'=>'66','create_time'=>'1621818439','update_time'=>'1621818439']);
        $this->insert('{{%store_label_link}}',['id'=>'127','bloc_id'=>'8','store_id'=>'0','label_id'=>'67','create_time'=>'1621818439','update_time'=>'1621818439']);
        $this->insert('{{%store_label_link}}',['id'=>'128','bloc_id'=>'8','store_id'=>'0','label_id'=>'63','create_time'=>'1621818492','update_time'=>'1621818492']);
        $this->insert('{{%store_label_link}}',['id'=>'129','bloc_id'=>'8','store_id'=>'0','label_id'=>'66','create_time'=>'1621818492','update_time'=>'1621818492']);
        $this->insert('{{%store_label_link}}',['id'=>'130','bloc_id'=>'8','store_id'=>'0','label_id'=>'73','create_time'=>'1621818492','update_time'=>'1621818492']);
        $this->insert('{{%store_label_link}}',['id'=>'131','bloc_id'=>'8','store_id'=>'0','label_id'=>'64','create_time'=>'1621818580','update_time'=>'1621818580']);
        $this->insert('{{%store_label_link}}',['id'=>'132','bloc_id'=>'8','store_id'=>'0','label_id'=>'66','create_time'=>'1621818580','update_time'=>'1621818580']);
        $this->insert('{{%store_label_link}}',['id'=>'133','bloc_id'=>'8','store_id'=>'0','label_id'=>'73','create_time'=>'1621818580','update_time'=>'1621818580']);
        $this->insert('{{%store_label_link}}',['id'=>'142','bloc_id'=>'11','store_id'=>'53','label_id'=>'62','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'143','bloc_id'=>'11','store_id'=>'53','label_id'=>'64','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'144','bloc_id'=>'11','store_id'=>'53','label_id'=>'67','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'145','bloc_id'=>'11','store_id'=>'53','label_id'=>'73','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'146','bloc_id'=>'29','store_id'=>'78','label_id'=>'62','create_time'=>'1641786902','update_time'=>'1641786902']);
        $this->insert('{{%store_label_link}}',['id'=>'147','bloc_id'=>'30','store_id'=>'79','label_id'=>'63','create_time'=>'1647505784','update_time'=>'1647505784']);
        $this->insert('{{%store_label_link}}',['id'=>'148','bloc_id'=>'30','store_id'=>'79','label_id'=>'66','create_time'=>'1647505784','update_time'=>'1647505784']);
        $this->insert('{{%store_label_link}}',['id'=>'149','bloc_id'=>'31','store_id'=>'80','label_id'=>'63','create_time'=>'1648634095','update_time'=>'1648634095']);
        
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

