<?php

use yii\db\Migration;

class m231104_123104_diandi_integral_goods_spec_rel extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods_spec_rel}}', [
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
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods_spec_rel}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

