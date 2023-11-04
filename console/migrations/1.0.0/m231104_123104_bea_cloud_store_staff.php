<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_store_staff extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_store_staff}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'is_boss' => "int(11) NULL DEFAULT '0' COMMENT '是否是老版'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'name' => "varchar(50) NULL COMMENT '员工名称'",
            'staff_code' => "varchar(50) NULL COMMENT '员工编码'",
            'mobile' => "varchar(50) NULL COMMENT '手机号'",
            'status' => "int(11) NULL COMMENT '状态'",
            'password' => "varchar(100) NULL COMMENT '密码'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='员工'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'1','store_id'=>'138','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'is_boss'=>'1','member_id'=>'1','name'=>NULL,'staff_code'=>NULL,'mobile'=>NULL,'status'=>'1','password'=>NULL]);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'2','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','is_boss'=>'0','member_id'=>NULL,'name'=>NULL,'staff_code'=>'123456','mobile'=>'17778984690','status'=>'1','password'=>NULL]);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'3','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-03-03 16:11:07','update_time'=>'2023-03-03 16:11:07','is_boss'=>'0','member_id'=>NULL,'name'=>'王春生','staff_code'=>'1255','mobile'=>'17778984690','status'=>'1','password'=>NULL]);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'4','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-03-03 16:16:00','update_time'=>'2023-03-03 16:16:00','is_boss'=>'0','member_id'=>NULL,'name'=>'王春生','staff_code'=>'125566','mobile'=>'17778984699','status'=>'1','password'=>NULL]);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'5','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-03-03 16:28:14','update_time'=>'2023-03-08 13:33:58','is_boss'=>'1','member_id'=>'83','name'=>'胡胡2','staff_code'=>'14785','mobile'=>'14785988547','status'=>'2','password'=>'1234567833444']);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'15','store_id'=>'149','bloc_id'=>'1','create_time'=>'2023-03-14 18:05:37','update_time'=>'2023-03-14 18:05:37','is_boss'=>'0','member_id'=>NULL,'name'=>'王春生','staff_code'=>NULL,'mobile'=>'17778984655','status'=>'1','password'=>'123123']);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'16','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-14 18:06:00','update_time'=>'2023-03-14 18:06:00','is_boss'=>'0','member_id'=>'117','name'=>'1店员工','staff_code'=>NULL,'mobile'=>'18092372647','status'=>'1','password'=>'123123']);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'20','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-14 18:18:44','update_time'=>'2023-03-14 18:33:44','is_boss'=>'1','member_id'=>'122','name'=>'2店员工2','staff_code'=>'','mobile'=>'18092372649','status'=>'1','password'=>'123123']);
        $this->insert('{{%bea_cloud_store_staff}}',['id'=>'19','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-14 18:18:22','update_time'=>'2023-03-14 19:19:22','is_boss'=>'0','member_id'=>'121','name'=>'2店员工1','staff_code'=>'','mobile'=>'18092372648','status'=>'1','password'=>'123123']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_store_staff}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

