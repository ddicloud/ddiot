<?php

use yii\db\Migration;

class m230714_032924_store_label_link extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store_label_link}}',['id'=>'93','bloc_id'=>'11','store_id'=>'55','label_id'=>'65','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'94','bloc_id'=>'11','store_id'=>'55','label_id'=>'67','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'95','bloc_id'=>'11','store_id'=>'55','label_id'=>'73','create_time'=>'1615455768','update_time'=>'1615455768']);
        $this->insert('{{%store_label_link}}',['id'=>'142','bloc_id'=>'11','store_id'=>'53','label_id'=>'62','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'143','bloc_id'=>'11','store_id'=>'53','label_id'=>'64','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'144','bloc_id'=>'11','store_id'=>'53','label_id'=>'67','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'145','bloc_id'=>'11','store_id'=>'53','label_id'=>'73','create_time'=>'1621824531','update_time'=>'1621824531']);
        $this->insert('{{%store_label_link}}',['id'=>'146','bloc_id'=>'13','store_id'=>'61','label_id'=>'63','create_time'=>'1657005079','update_time'=>'1657005079']);
        $this->insert('{{%store_label_link}}',['id'=>'149','bloc_id'=>'13','store_id'=>'63','label_id'=>'64','create_time'=>'1657790220','update_time'=>'1657790220']);
        $this->insert('{{%store_label_link}}',['id'=>'150','bloc_id'=>'13','store_id'=>'63','label_id'=>'65','create_time'=>'1657790220','update_time'=>'1657790220']);
        $this->insert('{{%store_label_link}}',['id'=>'151','bloc_id'=>'13','store_id'=>'63','label_id'=>'66','create_time'=>'1657790220','update_time'=>'1657790220']);
        $this->insert('{{%store_label_link}}',['id'=>'152','bloc_id'=>'13','store_id'=>'63','label_id'=>'63','create_time'=>'1657790220','update_time'=>'1657790220']);
        $this->insert('{{%store_label_link}}',['id'=>'154','bloc_id'=>'13','store_id'=>'64','label_id'=>'64','create_time'=>'1661399945','update_time'=>'1661399945']);
        $this->insert('{{%store_label_link}}',['id'=>'155','bloc_id'=>'13','store_id'=>'64','label_id'=>'66','create_time'=>'1661399945','update_time'=>'1661399945']);
        $this->insert('{{%store_label_link}}',['id'=>'156','bloc_id'=>'13','store_id'=>'64','label_id'=>'63','create_time'=>'1661399945','update_time'=>'1661399945']);
        $this->insert('{{%store_label_link}}',['id'=>'165','bloc_id'=>'35','store_id'=>'86','label_id'=>'63','create_time'=>'1667388438','update_time'=>'1667388438']);
        $this->insert('{{%store_label_link}}',['id'=>'168','bloc_id'=>'16','store_id'=>'136','label_id'=>'62','create_time'=>'1669168106','update_time'=>'1669168106']);
        $this->insert('{{%store_label_link}}',['id'=>'171','bloc_id'=>'35','store_id'=>'141','label_id'=>'63','create_time'=>'1677245020','update_time'=>'1677245020']);
        $this->insert('{{%store_label_link}}',['id'=>'172','bloc_id'=>'35','store_id'=>'141','label_id'=>'64','create_time'=>'1677245020','update_time'=>'1677245020']);
        $this->insert('{{%store_label_link}}',['id'=>'173','bloc_id'=>'35','store_id'=>'141','label_id'=>'65','create_time'=>'1677245020','update_time'=>'1677245020']);
        $this->insert('{{%store_label_link}}',['id'=>'194','bloc_id'=>'38','store_id'=>'138','label_id'=>'64','create_time'=>'1678255878','update_time'=>'1678255878']);
        $this->insert('{{%store_label_link}}',['id'=>'195','bloc_id'=>'38','store_id'=>'138','label_id'=>'63','create_time'=>'1678255878','update_time'=>'1678255878']);
        $this->insert('{{%store_label_link}}',['id'=>'197','bloc_id'=>'38','store_id'=>'140','label_id'=>'63','create_time'=>'1678363391','update_time'=>'1678363391']);
        $this->insert('{{%store_label_link}}',['id'=>'198','bloc_id'=>'49','store_id'=>'148','label_id'=>'63','create_time'=>'1678427343','update_time'=>'1678427343']);
        $this->insert('{{%store_label_link}}',['id'=>'207','bloc_id'=>'51','store_id'=>'151','label_id'=>'63','create_time'=>'1678785297','update_time'=>'1678785297']);
        $this->insert('{{%store_label_link}}',['id'=>'222','bloc_id'=>'51','store_id'=>'149','label_id'=>'62','create_time'=>'1678797238','update_time'=>'1678797238']);
        $this->insert('{{%store_label_link}}',['id'=>'223','bloc_id'=>'51','store_id'=>'149','label_id'=>'63','create_time'=>'1678797238','update_time'=>'1678797238']);
        $this->insert('{{%store_label_link}}',['id'=>'224','bloc_id'=>'51','store_id'=>'150','label_id'=>'65','create_time'=>'1679582264','update_time'=>'1679582264']);
        $this->insert('{{%store_label_link}}',['id'=>'225','bloc_id'=>'51','store_id'=>'150','label_id'=>'66','create_time'=>'1679582264','update_time'=>'1679582264']);
        $this->insert('{{%store_label_link}}',['id'=>'226','bloc_id'=>'38','store_id'=>'137','label_id'=>'62','create_time'=>'1681106129','update_time'=>'1681106129']);
        $this->insert('{{%store_label_link}}',['id'=>'227','bloc_id'=>'38','store_id'=>'137','label_id'=>'63','create_time'=>'1681106129','update_time'=>'1681106129']);
        $this->insert('{{%store_label_link}}',['id'=>'228','bloc_id'=>'38','store_id'=>'151','label_id'=>'63','create_time'=>'1687224883','update_time'=>'1687224883']);
        $this->insert('{{%store_label_link}}',['id'=>'229','bloc_id'=>'38','store_id'=>'151','label_id'=>'65','create_time'=>'1687224883','update_time'=>'1687224883']);
        $this->insert('{{%store_label_link}}',['id'=>'230','bloc_id'=>'38','store_id'=>'151','label_id'=>'66','create_time'=>'1687224883','update_time'=>'1687224883']);
        $this->insert('{{%store_label_link}}',['id'=>'231','bloc_id'=>'38','store_id'=>'151','label_id'=>'67','create_time'=>'1687224883','update_time'=>'1687224883']);
        $this->insert('{{%store_label_link}}',['id'=>'232','bloc_id'=>'38','store_id'=>'151','label_id'=>'73','create_time'=>'1687224883','update_time'=>'1687224883']);
        $this->insert('{{%store_label_link}}',['id'=>'250','bloc_id'=>'38','store_id'=>'152','label_id'=>'63','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'251','bloc_id'=>'38','store_id'=>'152','label_id'=>'63','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'252','bloc_id'=>'38','store_id'=>'152','label_id'=>'65','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'253','bloc_id'=>'38','store_id'=>'152','label_id'=>'66','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'254','bloc_id'=>'38','store_id'=>'152','label_id'=>'67','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'255','bloc_id'=>'38','store_id'=>'152','label_id'=>'73','create_time'=>'1687227068','update_time'=>'1687227068']);
        $this->insert('{{%store_label_link}}',['id'=>'259','bloc_id'=>'91','store_id'=>'153','label_id'=>'62','create_time'=>'1687236666','update_time'=>'1687236666']);
        $this->insert('{{%store_label_link}}',['id'=>'260','bloc_id'=>'91','store_id'=>'153','label_id'=>'64','create_time'=>'1687236666','update_time'=>'1687236666']);
        $this->insert('{{%store_label_link}}',['id'=>'261','bloc_id'=>'91','store_id'=>'153','label_id'=>'65','create_time'=>'1687236666','update_time'=>'1687236666']);
        
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

