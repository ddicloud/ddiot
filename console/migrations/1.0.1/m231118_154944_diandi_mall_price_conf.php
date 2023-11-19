<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_price_conf extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_price_conf}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'pricefield' => "varchar(10) NULL COMMENT '价格字段'",
            'name' => "varchar(10) NULL COMMENT '字段名称'",
            'is_use' => "int(11) NULL COMMENT '是否使用'",
            'level_id' => "int(11) NULL COMMENT '等级id'",
            'group_id' => "int(11) NULL COMMENT '分销商id'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='价格字段说明'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_price_conf}}','level_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_price_conf}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

