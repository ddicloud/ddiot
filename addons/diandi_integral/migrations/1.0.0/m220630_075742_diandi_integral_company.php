<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-30 15:57:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 15:58:10
 */

use yii\db\Migration;

class m220630_075742_diandi_integral_company extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%diandi_integral_company}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'title' => "varchar(255) NULL COMMENT '名称'",
            'code' => "varchar(255) NULL COMMENT '编码'",
            'status' => "int(255) NULL DEFAULT '0' COMMENT '是否启用 1.启用 0.关闭'",
            'display_order' => "int(11) NULL COMMENT '排序'",
            'mobile' => "varchar(20) NULL COMMENT '联系电话'",
            'link_man' => "varchar(30) NULL COMMENT '联系人'",
            'is_default' => "int(11) NULL COMMENT '是否默认 1.默认 0.不默认'",
            'create_time' => 'int(11) NULL',
            'update_time' => 'int(11) NULL',
            'store_id' => 'int(11) NULL',
            'bloc_id' => 'int(11) NULL',
            'PRIMARY KEY (`id`)',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        /* 索引设置 */

        /* 表数据 */
        $this->insert('{{%diandi_integral_company}}', ['id' => '1', 'title' => '顺丰', 'code' => 'shunf', 'status' => '1', 'display_order' => '1', 'mobile' => '15645', 'link_man' => '王春生', 'is_default' => '0', 'create_time' => null, 'update_time' => '1646102238', 'store_id' => null, 'bloc_id' => null]);
        $this->insert('{{%diandi_integral_company}}', ['id' => '4', 'title' => '申通', 'code' => '324', 'status' => '0', 'display_order' => '1', 'mobile' => '111', 'link_man' => '35', 'is_default' => null, 'create_time' => '1648609542', 'update_time' => '1648609759', 'store_id' => '79', 'bloc_id' => '30']);

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_company}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
