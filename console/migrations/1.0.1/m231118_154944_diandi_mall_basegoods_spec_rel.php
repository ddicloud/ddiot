<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_basegoods_spec_rel extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_basegoods_spec_rel}}', [
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_basegoods_spec_rel}}',['id'=>'1','store_id'=>'62','bloc_id'=>'13','goods_id'=>'2','thumb'=>'','spec_id'=>'1','spec_value_id'=>'1','create_time'=>'1657695165','spec_item_show'=>'1']);
        $this->insert('{{%diandi_mall_basegoods_spec_rel}}',['id'=>'3','store_id'=>'62','bloc_id'=>'13','goods_id'=>'3','thumb'=>'','spec_id'=>'1','spec_value_id'=>'1','create_time'=>'1657785104','spec_item_show'=>'1']);
        $this->insert('{{%diandi_mall_basegoods_spec_rel}}',['id'=>'5','store_id'=>'62','bloc_id'=>'13','goods_id'=>'1','thumb'=>'','spec_id'=>'1','spec_value_id'=>'2','create_time'=>'1658715418','spec_item_show'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_basegoods_spec_rel}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

