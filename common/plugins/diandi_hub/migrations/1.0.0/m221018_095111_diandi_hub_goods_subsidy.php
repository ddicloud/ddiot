<?php

use yii\db\Migration;

class m221018_095111_diandi_hub_goods_subsidy extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_goods_subsidy}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'goods_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'integral_redio' => "decimal(11,2) NULL COMMENT '积分补贴比例'",
            'credit1' => "decimal(11,2) NULL COMMENT 'credit1返利'",
            'credit2' => "decimal(11,2) NULL COMMENT 'credit2返利'",
            'credit3' => "decimal(11,2) NULL COMMENT 'credit3返利'",
            'credit4' => "decimal(11,2) NULL COMMENT 'credit4返利'",
            'credit5' => "decimal(11,2) NULL COMMENT 'credit5返利'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
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
        $this->dropTable('{{%diandi_hub_goods_subsidy}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

