<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_level_base_conf extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_level_base_conf}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'levelnum' => "int(11) NOT NULL DEFAULT '0' COMMENT '当前等级'",
            'levelcnum' => "int(11) NULL DEFAULT '0' COMMENT '发展等级'",
            'level1_radio' => "decimal(11,3) NULL COMMENT '一级分销比例'",
            'level2_radio' => "decimal(11,3) NULL COMMENT '二级分销比例'",
            'level3_radio' => "decimal(11,3) NULL COMMENT '三级分销比例'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_level_base_conf}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

