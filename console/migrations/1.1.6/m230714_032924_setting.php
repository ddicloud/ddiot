<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-14 11:29:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-17 17:13:56
 */


use yii\db\Migration;

class m230714_032924_setting extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%setting}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'cate_name' => "varchar(255) NULL",
            'type' => "varchar(10) NOT NULL",
            'section' => "varchar(255) NOT NULL",
            'key' => "varchar(255) NOT NULL",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'value' => "text NOT NULL",
            'status' => "smallint(6) NOT NULL DEFAULT '1'",
            'description' => "varchar(255) NULL",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT");

        /* 索引设置 */


        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%setting}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
