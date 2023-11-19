<?php

use yii\db\Migration;

class m231118_154943_bloc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc}}', [
            'bloc_id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'invitation_code' => "varchar(50) NULL COMMENT '邀请码'",
            'business_name' => "varchar(50) NOT NULL COMMENT '公司名称'",
            'logo' => "varchar(255) NULL COMMENT '公司logo'",
            'pid' => "int(11) NULL DEFAULT '0' COMMENT '上级商户'",
            'group_bloc_id' => "int(11) NULL DEFAULT '38' COMMENT '集团ID'",
            'category' => "varchar(255) NULL DEFAULT '0'",
            'province' => "int(11) NULL COMMENT '省份'",
            'city' => "int(11) NULL COMMENT '城市'",
            'district' => "int(11) NULL COMMENT '区县'",
            'address' => "varchar(50) NULL COMMENT '具体地址'",
            'register_level' => "int(11) NULL COMMENT '注册级别'",
            'longitude' => "varchar(15) NULL COMMENT '经度'",
            'latitude' => "varchar(15) NULL COMMENT '纬度'",
            'telephone' => "varchar(20) NULL COMMENT '电话'",
            'avg_price' => "int(10) unsigned NULL",
            'recommend' => "varchar(255) NULL COMMENT '介绍'",
            'special' => "varchar(255) NULL COMMENT '特色'",
            'store_num' => "int(11) NULL",
            'introduction' => "varchar(255) NULL COMMENT '详细介绍'",
            'open_time' => "datetime NULL COMMENT '开业时间'",
            'end_time' => "datetime NULL COMMENT '有效期'",
            'status' => "tinyint(3) unsigned NULL DEFAULT '0' COMMENT '0 待审核 1 审核通过 2 审核未通过'",
            'is_group' => "tinyint(3) NULL DEFAULT '0' COMMENT '是否是集团'",
            'sosomap_poi_uid' => "varchar(50) NULL DEFAULT '' COMMENT '腾讯地图标注id'",
            'license_no' => "varchar(30) NULL DEFAULT '' COMMENT '营业执照注册号或组织机构代码'",
            'license_name' => "varchar(100) NULL DEFAULT '' COMMENT '营业执照名称'",
            'level_num' => "int(11) NULL COMMENT '等级'",
            'store_id' => "int(11) NULL DEFAULT '0'",
            'other_files' => "text NULL COMMENT '其他文件'",
            'extra' => "text NULL COMMENT '我的家族'",
            'pay_bloc_id' => "int(11) NULL",
            'PRIMARY KEY (`bloc_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bloc}}',['bloc_id'=>'38','invitation_code'=>'o2edw','business_name'=>'店滴云','logo'=>'','pid'=>'0','group_bloc_id'=>NULL,'category'=>'0','province'=>'2670','city'=>'2724','district'=>'2725','address'=>'西安钟楼','register_level'=>'1','longitude'=>'108.953509','latitude'=>'34.265619','telephone'=>'17778984690','avg_price'=>'12','recommend'=>'23','special'=>'12','store_num'=>NULL,'introduction'=>'23','open_time'=>'1970-01-01 08:32:50','end_time'=>NULL,'status'=>'1','is_group'=>'1','sosomap_poi_uid'=>'','license_no'=>'1212','license_name'=>'23','level_num'=>'1','store_id'=>'0','other_files'=>'','extra'=>NULL,'pay_bloc_id'=>NULL]);
        $this->insert('{{%bloc}}',['bloc_id'=>'91','invitation_code'=>'wGGvw','business_name'=>'马来西亚1','logo'=>'202306/20/1f7da9b4-1fc6-3ff2-b3bb-7ef2319c7322.jpg','pid'=>'38','group_bloc_id'=>'38','category'=>'','province'=>'801','city'=>'802','district'=>'813','address'=>'12号楼','register_level'=>'0','longitude'=>'116.700848','latitude'=>'39.899696','telephone'=>'17778984690','avg_price'=>'12','recommend'=>'简介','special'=>'特色','store_num'=>NULL,'introduction'=>'详细介绍品牌','open_time'=>'2023-06-20 00:00:00','end_time'=>'2023-06-30 00:00:00','status'=>'1','is_group'=>'0','sosomap_poi_uid'=>'','license_no'=>'156784548976548','license_name'=>'公司名称','level_num'=>'1','store_id'=>'0','other_files'=>NULL,'extra'=>NULL,'pay_bloc_id'=>NULL]);
        
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

