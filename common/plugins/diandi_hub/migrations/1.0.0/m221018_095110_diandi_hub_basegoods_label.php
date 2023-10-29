<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_basegoods_label extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_basegoods_label}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'label' => "varchar(4) NULL COMMENT '商品标签'",
            'thumb' => "varchar(255) NULL COMMENT '标签图片'",
            'color' => "varchar(10) NULL COMMENT '标签颜色'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('store_id','{{%diandi_hub_basegoods_label}}','store_id, bloc_id, label',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_basegoods_label}}',['id'=>'4','store_id'=>'82','bloc_id'=>'33','label'=>'标签er','thumb'=>'','color'=>'#409EFF']);
        $this->insert('{{%diandi_hub_basegoods_label}}',['id'=>'2','store_id'=>'75','bloc_id'=>'27','label'=>'颜色','thumb'=>'202202/26/d20dbf16-31e6-3baf-a41e-8117289cc26b.jpg','color'=>'#409EFF']);
        $this->insert('{{%diandi_hub_basegoods_label}}',['id'=>'5','store_id'=>'80','bloc_id'=>'31','label'=>'基地','thumb'=>'202205/26/9a1e49be-0929-3940-9232-8b7dbd1107f6.png','color'=>'#409EFF']);
        $this->insert('{{%diandi_hub_basegoods_label}}',['id'=>'6','store_id'=>'80','bloc_id'=>'31','label'=>'种植户','thumb'=>NULL,'color'=>'#409EFF']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_basegoods_label}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

