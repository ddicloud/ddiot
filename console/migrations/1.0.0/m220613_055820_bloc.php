<?php

use yii\db\Migration;

class m220613_055820_bloc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc}}', [
            'bloc_id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'business_name' => "varchar(50) NOT NULL COMMENT '公司名称'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '上级商户'",
            'group_bloc_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '集团ID'",
            'category' => "varchar(255) NOT NULL DEFAULT '0'",
            'province' => "varchar(15) NOT NULL COMMENT '省份'",
            'city' => "varchar(15) NOT NULL COMMENT '城市'",
            'district' => "varchar(15) NOT NULL COMMENT '区县'",
            'address' => "varchar(50) NOT NULL COMMENT '具体地址'",
            'register_level' => "int(11) NOT NULL COMMENT '注册级别'",
            'longitude' => "varchar(15) NOT NULL COMMENT '经度'",
            'latitude' => "varchar(15) NOT NULL COMMENT '纬度'",
            'telephone' => "varchar(20) NOT NULL COMMENT '电话'",
            'avg_price' => "int(10) unsigned NOT NULL",
            'recommend' => "varchar(255) NOT NULL COMMENT '介绍'",
            'special' => "varchar(255) NOT NULL COMMENT '特色'",
            'introduction' => "varchar(255) NOT NULL COMMENT '详细介绍'",
            'open_time' => "varchar(50) NOT NULL COMMENT '开业时间'",
            'status' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 待审核 1 审核通过 2 审核未通过'",
            'is_group' => "tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否是集团'",
            'sosomap_poi_uid' => "varchar(50) NOT NULL DEFAULT '' COMMENT '腾讯地图标注id'",
            'license_no' => "varchar(30) NOT NULL DEFAULT '' COMMENT '营业执照注册号或组织机构代码'",
            'license_name' => "varchar(100) NOT NULL DEFAULT '' COMMENT '营业执照名称'",
            'level_num' => "int(11) NULL COMMENT '等级'",
            'store_id' => "int(11) NOT NULL DEFAULT '0'",
            'other_files' => "text NULL COMMENT '其他文件'",
            'extra' => "text NULL COMMENT '我的家族'",
            'PRIMARY KEY (`bloc_id`)'
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
        $this->dropTable('{{%bloc}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

