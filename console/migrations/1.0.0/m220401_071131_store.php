<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-01 15:11:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-01 19:39:23
 */

use yii\db\Migration;

class m220401_071131_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%store}}', [
            'store_id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '商户id'",
            'category_id' => 'int(11) NOT NULL',
            'category_pid' => 'int(11) NOT NULL',
            'name' => "varchar(255) NULL COMMENT '门店名称'",
            'logo' => 'varchar(255) NULL',
            'bloc_id' => "int(11) NULL COMMENT '关联公司'",
            'province' => "varchar(10) NULL COMMENT '省份'",
            'city' => "varchar(10) NULL COMMENT '城市'",
            'address' => "varchar(255) NULL COMMENT '详细地址'",
            'county' => "varchar(10) NULL COMMENT '区县'",
            'mobile' => "varchar(11) NULL COMMENT '联系电话'",
            'create_time' => 'varchar(30) NULL',
            'update_time' => 'varchar(30) NULL',
            'status' => "int(10) NULL DEFAULT '0' COMMENT '0:待审核,1:已通过,3:已拉黑'",
            'lng_lat' => "varchar(100) NULL COMMENT '经纬度'",
            'extra' => "text NULL COMMENT '商户扩展字段'",
            'longitude' => 'varchar(255) NOT NULL',
            'latitude' => 'varchar(255) NOT NULL',
            'PRIMARY KEY (`store_id`)',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

        /* 索引设置 */

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
