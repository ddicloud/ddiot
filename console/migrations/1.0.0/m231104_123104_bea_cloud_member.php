<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_member}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'avatar' => "varchar(255) NULL COMMENT '头像'",
            'name' => "varchar(50) NULL COMMENT '名称'",
            'mobile' => "varchar(100) NULL COMMENT '手机号'",
            'gender' => "int(11) NULL COMMENT '性别'",
            'birthday' => "datetime NULL COMMENT '生日'",
            'accumulated_income' => "decimal(11,2) NULL COMMENT '累计收益'",
            'account_frozen' => "decimal(11,2) NULL COMMENT '冻结金额'",
            'cash_money' => "decimal(11,2) NULL COMMENT '可提现'",
            'cash_in' => "decimal(11,2) NULL COMMENT '提现中'",
            'cash_total' => "decimal(11,2) NULL COMMENT '总提现'",
            'member_type' => "int(11) NULL DEFAULT '0' COMMENT '会员类型'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='会员主表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_member}}',['id'=>'2','store_id'=>'137','bloc_id'=>'38','create_time'=>'2023-02-20 14:41:48','update_time'=>'2023-02-20 14:41:48','member_id'=>'83','avatar'=>'https://dev.ddicms.cn/attachment/202302/24/37fa19ab-3dc5-3cf9-b64f-0db04b006e98.jpg','name'=>'李四','mobile'=>'17778984690','gender'=>'0','birthday'=>'2023-02-20 11:12:32','accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'3','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-02-20 20:17:24','update_time'=>'2023-02-20 20:17:24','member_id'=>'84','avatar'=>'undefined','name'=>'张三','mobile'=>'12312312300','gender'=>'1','birthday'=>'2023-01-27 00:00:00','accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'4','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-02-26 20:14:46','update_time'=>'2023-02-26 20:14:46','member_id'=>'86','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'5','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-02-27 11:25:47','update_time'=>'2023-02-27 11:25:47','member_id'=>'1','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'6','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-03 18:58:25','update_time'=>'2023-03-03 18:58:25','member_id'=>'89','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'7','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-04 13:33:54','update_time'=>'2023-03-04 13:33:54','member_id'=>'90','avatar'=>'undefined','name'=>'哇哈哈哈哈','mobile'=>'13112312313','gender'=>'1','birthday'=>'2023-03-06 00:00:00','accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'8','store_id'=>'140','bloc_id'=>'38','create_time'=>'2023-03-07 21:03:16','update_time'=>'2023-03-07 21:03:16','member_id'=>'93','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'9','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-08 14:08:03','update_time'=>'2023-03-08 14:08:03','member_id'=>'94','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'10','store_id'=>'136','bloc_id'=>'38','create_time'=>'2023-03-08 14:09:02','update_time'=>'2023-03-08 14:09:02','member_id'=>'95','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>NULL]);
        $this->insert('{{%bea_cloud_member}}',['id'=>'11','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:30:11','update_time'=>'2023-03-13 09:30:11','member_id'=>'101','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'12','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:36:03','update_time'=>'2023-03-13 09:36:03','member_id'=>'102','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'13','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:39:12','update_time'=>'2023-03-13 09:39:12','member_id'=>'103','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'14','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:44:12','update_time'=>'2023-03-13 09:44:12','member_id'=>'104','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'15','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:46:27','update_time'=>'2023-03-13 09:46:27','member_id'=>'106','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'16','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 09:47:40','update_time'=>'2023-03-13 09:47:40','member_id'=>'107','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'17','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 10:04:29','update_time'=>'2023-03-23 20:15:59','member_id'=>'108','avatar'=>'https://bea.ddicms.cn/attachment/202303/22/fae69117-0815-39b2-b63d-2cd3a62b3f39.jpg','name'=>'王春1生','mobile'=>'17778984690','gender'=>'0','birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'2.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'18','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-13 21:10:08','update_time'=>'2023-03-13 21:10:08','member_id'=>'115','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'19','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-14 09:16:18','update_time'=>'2023-03-14 09:16:18','member_id'=>'116','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'20','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-14 18:36:52','update_time'=>'2023-03-14 18:36:52','member_id'=>'117','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'21','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-14 19:03:27','update_time'=>'2023-03-14 19:03:27','member_id'=>'121','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'22','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-15 17:42:10','update_time'=>'2023-03-15 17:42:10','member_id'=>'123','avatar'=>'https://bea.ddicms.cn/attachment/202303/23/216ec9f1-be5c-36d0-a00a-d3999bf4c899.jpeg','name'=>'wy','mobile'=>'13111111111','gender'=>'1','birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'23','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-15 18:56:25','update_time'=>'2023-03-23 21:47:13','member_id'=>'124','avatar'=>'https://bea.ddicms.cn/attachment/202303/23/e51c7c2d-7bbb-39a9-9955-0d0ba7824681.png','name'=>'马同杰','mobile'=>'18092372645','gender'=>'0','birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'8.00','cash_money'=>'3.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'24','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-18 18:51:44','update_time'=>'2023-03-18 18:51:44','member_id'=>'122','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'25','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 14:25:34','update_time'=>'2023-03-20 14:25:34','member_id'=>'125','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'26','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-22 01:38:54','update_time'=>'2023-03-22 01:38:54','member_id'=>'126','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'29','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-23 10:49:41','update_time'=>'2023-03-23 10:49:41','member_id'=>'129','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'27','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-22 16:03:44','update_time'=>'2023-03-22 16:03:44','member_id'=>'127','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'28','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-22 19:59:08','update_time'=>'2023-03-22 19:59:08','member_id'=>'128','avatar'=>'undefined','name'=>'哈利波特','mobile'=>'17778984690','gender'=>'0','birthday'=>'2023-03-23 00:00:00','accumulated_income'=>'0.00','account_frozen'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'30','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-23 19:51:24','update_time'=>'2023-03-23 19:51:24','member_id'=>'130','avatar'=>'好的伙计','name'=>'好的伙计','mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>NULL,'account_frozen'=>NULL,'cash_money'=>NULL,'cash_in'=>NULL,'cash_total'=>NULL,'member_type'=>'0']);
        $this->insert('{{%bea_cloud_member}}',['id'=>'31','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-23 22:20:51','update_time'=>'2023-03-23 22:20:51','member_id'=>'131','avatar'=>NULL,'name'=>NULL,'mobile'=>NULL,'gender'=>NULL,'birthday'=>NULL,'accumulated_income'=>NULL,'account_frozen'=>NULL,'cash_money'=>NULL,'cash_in'=>NULL,'cash_total'=>NULL,'member_type'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

