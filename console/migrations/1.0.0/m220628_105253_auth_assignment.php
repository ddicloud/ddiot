<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-28 18:52:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 19:54:52
 */

use yii\db\Migration;

class m220628_105253_auth_assignment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%auth_assignment}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'item_id' => 'int(11) NOT NULL',
            'item_name' => 'varchar(64) NOT NULL',
            'user_id' => 'varchar(64) NOT NULL',
            'created_at' => 'int(11) NULL',
            'PRIMARY KEY (`id`)',
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户与权限关系'");

        /* 索引设置 */
        $this->createIndex('auth_assignment_user_id_idx', '{{%auth_assignment}}', 'user_id', 0);

        /* 表数据 */

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_assignment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
