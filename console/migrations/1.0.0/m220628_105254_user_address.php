<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-28 18:52:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 19:54:29
 */

use yii\db\Migration;

class m220628_105254_user_address extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%user_address}}', [
            'address_id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'name' => "varchar(30) NOT NULL DEFAULT ''",
            'phone' => "varchar(20) NOT NULL DEFAULT ''",
            'country' => "varchar(255) NULL COMMENT '国家'",
            'province_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'city_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'region_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'detail' => "varchar(255) NOT NULL DEFAULT ''",
            'user_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'is_default' => "tinyint(4) NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`address_id`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /* 索引设置 */

        /* 表数据 */

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_address}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
