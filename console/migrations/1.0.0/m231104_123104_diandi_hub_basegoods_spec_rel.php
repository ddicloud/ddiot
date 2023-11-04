<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_basegoods_spec_rel extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_basegoods_spec_rel}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id'",
            'thumb' => "varchar(255) NULL COMMENT '商品图片'",
            'spec_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性id'",
            'spec_value_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性值组合id'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'spec_item_show' => "int(11) NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'8','store_id'=>'80','bloc_id'=>'31','goods_id'=>'6','thumb'=>'','spec_id'=>'4','spec_value_id'=>'28','create_time'=>'1657183082','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'12','store_id'=>'80','bloc_id'=>'31','goods_id'=>'10','thumb'=>'','spec_id'=>'4','spec_value_id'=>'28','create_time'=>'1657183925','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'14','store_id'=>'80','bloc_id'=>'31','goods_id'=>'12','thumb'=>'','spec_id'=>'4','spec_value_id'=>'28','create_time'=>'1657184291','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'15','store_id'=>'80','bloc_id'=>'31','goods_id'=>'13','thumb'=>'','spec_id'=>'4','spec_value_id'=>'28','create_time'=>'1657184369','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'24','store_id'=>'80','bloc_id'=>'31','goods_id'=>'22','thumb'=>'','spec_id'=>'4','spec_value_id'=>'28','create_time'=>'1657184615','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'25','store_id'=>'80','bloc_id'=>'31','goods_id'=>'23','thumb'=>'','spec_id'=>'1','spec_value_id'=>'33','create_time'=>'1657195170','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'26','store_id'=>'80','bloc_id'=>'31','goods_id'=>'23','thumb'=>'','spec_id'=>'7','spec_value_id'=>'37','create_time'=>'1657195170','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'27','store_id'=>'80','bloc_id'=>'31','goods_id'=>'24','thumb'=>'','spec_id'=>'1','spec_value_id'=>'33','create_time'=>'1665652820','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'28','store_id'=>'80','bloc_id'=>'31','goods_id'=>'24','thumb'=>'','spec_id'=>'7','spec_value_id'=>'37','create_time'=>'1665652820','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'29','store_id'=>'0','bloc_id'=>'0','goods_id'=>'26','thumb'=>'','spec_id'=>'18','spec_value_id'=>'81','create_time'=>'1666954094','spec_item_show'=>'1']);
        $this->insert('{{%diandi_hub_basegoods_spec_rel}}',['id'=>'30','store_id'=>'86','bloc_id'=>'35','goods_id'=>'27','thumb'=>'','spec_id'=>'19','spec_value_id'=>'82','create_time'=>'1667642130','spec_item_show'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_basegoods_spec_rel}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

