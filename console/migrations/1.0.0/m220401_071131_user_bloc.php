<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-01 15:11:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-01 19:39:10
 */

use yii\db\Migration;

class m220401_071131_user_bloc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%user_bloc}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'user_id' => "int(11) NULL DEFAULT '0' COMMENT '管理员id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '集团id'",
            'store_id' => "int(11) NULL DEFAULT '0' COMMENT '子公司id'",
            'status' => "int(11) NULL COMMENT '是否启用'",
            'is_default' => "smallint(6) NULL DEFAULT '0' COMMENT '是否默认'",
            'create_time' => 'varchar(30) NULL',
            'update_time' => 'varchar(30) NULL',
            'PRIMARY KEY (`id`)',
        ], 'ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

        /* 索引设置 */

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_bloc}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
