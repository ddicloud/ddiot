<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_rules extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_rules}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'goods_spec_id' => "int(11) NULL COMMENT '属性id'",
            'type' => "varchar(30) NULL DEFAULT '比例' COMMENT '分销方式'",
            'group_id' => "int(11) NULL COMMENT '分销商id'",
            'level_id' => "int(11) NULL COMMENT '会员等级'",
            'status' => "int(11) NULL",
            'money1' => "decimal(10,2) NULL",
            'money2' => "decimal(10,2) NULL",
            'money3' => "decimal(11,2) NULL COMMENT '分销参数'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='分销规则设置'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_rules}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

