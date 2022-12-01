<?php

use yii\db\Migration;

class m220628_105253_bloc_conf_map extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_map}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'baiduApk' => "varchar(255) NULL",
            'amapApk' => "varchar(255) NULL",
            'tencentApk' => "varchar(255) NULL",
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
        $this->dropTable('{{%bloc_conf_map}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

