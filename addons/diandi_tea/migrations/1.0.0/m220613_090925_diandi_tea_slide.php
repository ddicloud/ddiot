<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-13 17:09:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 17:11:47
 */

use yii\db\Migration;

class m220613_090925_diandi_tea_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%diandi_tea_slide}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => 'int(11) NOT NULL',
            'create_time' => 'datetime NULL',
            'update_time' => 'datetime NULL',
            'slide' => "varchar(255) NULL COMMENT '轮播图'",
            'type' => "tinyint(3) NULL COMMENT '幻灯片类型: 1.商店头部幻灯片  2.商店中间幻灯片'",
            'PRIMARY KEY (`id`)',
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='全局配置表'");

        /* 索引设置 */

        /* 表数据 */
        $this->insert('{{%diandi_tea_slide}}', ['id' => '6', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-03-31 16:58:05', 'update_time' => '2022-04-24 09:50:37', 'slide' => '202204/24/14d5f86a-47a2-39fd-82f3-41cf46c44edd.jpeg', 'type' => '2']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '8', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-03-31 16:58:05', 'update_time' => '2022-06-12 13:13:14', 'slide' => '202206/12/6c8ad8e7-cde8-31b9-88d6-22a0d8a4bf5f.jpg', 'type' => '1']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '9', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-03-31 16:58:05', 'update_time' => '2022-06-02 17:44:57', 'slide' => '202204/24/7f0ae90b-4107-318d-b793-e2385d8e2d6c.jpeg', 'type' => '2']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '10', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-03-31 16:58:05', 'update_time' => '2022-06-12 13:13:39', 'slide' => '202206/12/f5efc1cc-d070-3714-92a7-9e627591d80b.jpg', 'type' => '1']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '11', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-06-12 13:14:02', 'update_time' => '2022-06-12 13:14:02', 'slide' => '202206/12/8c1035fc-fcf4-35b9-b717-2ac2b3c67bfa.jpg', 'type' => '1']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '12', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-06-12 13:14:23', 'update_time' => '2022-06-12 13:14:23', 'slide' => '202206/12/71c17e15-419b-327b-9ce4-b32610d0f48e.jpg', 'type' => '1']);
        $this->insert('{{%diandi_tea_slide}}', ['id' => '13', 'bloc_id' => '30', 'store_id' => '79', 'create_time' => '2022-06-12 13:14:44', 'update_time' => '2022-06-12 13:14:44', 'slide' => '202206/12/db0e1229-b1a1-36ca-8edf-67115b176dae.jpg', 'type' => '1']);

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
