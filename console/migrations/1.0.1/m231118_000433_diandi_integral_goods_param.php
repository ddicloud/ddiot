<?php

use yii\db\Migration;

class m231118_000433_diandi_integral_goods_param extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods_param}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'goods_id' => "int(10) NULL DEFAULT '0' COMMENT '商品id'",
            'title' => "varchar(50) NULL DEFAULT '' COMMENT '属性名称'",
            'value' => "varchar(50) NULL COMMENT '属性值'",
            'displayorder' => "int(11) NULL DEFAULT '0' COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods_param}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

