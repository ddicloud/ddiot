<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_bloc extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_bloc}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(50) NULL COMMENT '商家名称'",
            'logo' => "varchar(255) NULL COMMENT '公司logo'",
            'service_money' => "decimal(11,2) NULL COMMENT '开发服务费'",
            'mobile' => "varchar(11) NULL COMMENT '联系电话'",
            'activity_num' => "int(11) NULL DEFAULT '0' COMMENT '进行中活动数量'",
            'sale_total' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '总营收'",
            'fund_in_float' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '在途资金'",
            'cash_money' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '可提现'",
            'cash_in' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '提现中'",
            'cash_total' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '总提现'",
            'cash_rate' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '提现费率'",
            'order_rate' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '交易费率'",
            'platform_rate' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '平台使用费率'",
            'status' => "tinyint(4) NULL DEFAULT '0' COMMENT '商家状态'",
            'official_receipts' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '商家实收'",
            'sharer_total' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '分享者收入'",
            'is_shop' => "int(11) NULL DEFAULT '0' COMMENT '是否开启商城'",
            'is_pledge' => "tinyint(4) NULL DEFAULT '0' COMMENT '资金是否滞留'",
            'cash_pledge' => "decimal(11,2) NULL DEFAULT '0.00' COMMENT '滞留比例'",
            'fans_num' => "int(11) NULL DEFAULT '0' COMMENT '粉丝数量'",
            'start_time' => "datetime NULL COMMENT '开始期限'",
            'end_time' => "datetime NULL COMMENT '到期期限'",
            'qrcode' => "varchar(255) NULL COMMENT '二维码'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'1','bloc_id'=>'38','create_time'=>'2023-03-07 17:02:49','update_time'=>'2023-03-23 20:00:32','title'=>'商家名称1','logo'=>'','service_money'=>NULL,'mobile'=>'','activity_num'=>'0','sale_total'=>'1.00','fund_in_float'=>'2.00','cash_money'=>'6.10','cash_in'=>'1.00','cash_total'=>'1.00','cash_rate'=>NULL,'order_rate'=>NULL,'platform_rate'=>NULL,'status'=>'1','official_receipts'=>'1.00','sharer_total'=>'1.00','is_shop'=>'1','is_pledge'=>'1','cash_pledge'=>'1.00','fans_num'=>'1','start_time'=>'2023-02-26 13:26:38','end_time'=>'2023-02-26 13:26:38','qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'38','bloc_id'=>'49','create_time'=>'2023-03-10 13:47:55','update_time'=>'2023-03-10 13:47:55','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'39','bloc_id'=>'50','create_time'=>'2023-03-10 17:39:21','update_time'=>'2023-03-10 17:39:21','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'36','bloc_id'=>'39','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'35','bloc_id'=>'43','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'34','bloc_id'=>'35','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'32','bloc_id'=>'42','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'33','bloc_id'=>'35','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'31','bloc_id'=>'41','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'30','bloc_id'=>'45','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'29','bloc_id'=>'46','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'28','bloc_id'=>'47','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'27','bloc_id'=>'48','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'26','bloc_id'=>'16','create_time'=>'2023-03-10 13:42:32','update_time'=>'2023-03-10 13:42:32','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'37','bloc_id'=>'40','create_time'=>'2023-03-10 13:42:36','update_time'=>'2023-03-10 13:42:36','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'24','bloc_id'=>'39','create_time'=>'2023-03-10 13:42:31','update_time'=>'2023-03-10 13:42:31','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'23','bloc_id'=>'44','create_time'=>'2023-03-10 13:42:31','update_time'=>'2023-03-10 13:42:31','title'=>NULL,'logo'=>NULL,'service_money'=>NULL,'mobile'=>NULL,'activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'0.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.00','platform_rate'=>'0.00','status'=>'0','official_receipts'=>'0.00','sharer_total'=>'0.00','is_shop'=>'0','is_pledge'=>NULL,'cash_pledge'=>NULL,'fans_num'=>NULL,'start_time'=>NULL,'end_time'=>NULL,'qrcode'=>NULL]);
        $this->insert('{{%bea_cloud_bloc}}',['id'=>'40','bloc_id'=>'51','create_time'=>'2023-03-10 22:16:35','update_time'=>'2023-03-23 22:29:49','title'=>'','logo'=>'202303/13/3d05f0bc-401e-3bae-bc20-3324f29a4717.png','service_money'=>'1.00','mobile'=>'','activity_num'=>'0','sale_total'=>'0.00','fund_in_float'=>'0.00','cash_money'=>'16.00','cash_in'=>'0.00','cash_total'=>'0.00','cash_rate'=>'0.00','order_rate'=>'0.60','platform_rate'=>'5.00','status'=>'1','official_receipts'=>'0.00','sharer_total'=>'6.00','is_shop'=>'1','is_pledge'=>'1','cash_pledge'=>'5.00','fans_num'=>'0','start_time'=>NULL,'end_time'=>'2023-03-31 00:00:00','qrcode'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_bloc}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

