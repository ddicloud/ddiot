<?php

use yii\db\Migration;

class m211229_023908_weihai_bigscreen_ceshi extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%weihai_bigscreen_ceshi}}', [
            'id' => "int(11) NOT NULL",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'ceshi' => "varchar(255) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%weihai_bigscreen_ceshi}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

