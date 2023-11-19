<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NULL",
            'name' => "varchar(30) NULL COMMENT '商家名称'",
            'mobile' => "varchar(30) NOT NULL COMMENT '商家手机号'",
            'address' => "varchar(100) NULL COMMENT '商家地址'",
            'city' => "int(11) NULL COMMENT '城市'",
            'provice' => "int(11) NULL COMMENT '省份'",
            'area' => "int(11) NULL COMMENT '区域'",
            'desc' => "varchar(255) NULL COMMENT '店铺介绍'",
            'linkman' => "varchar(30) NULL COMMENT '联系人'",
            'storefront' => "varchar(255) NULL COMMENT '店面门头'",
            'business' => "varchar(255) NULL COMMENT '营业执照'",
            'cardFront' => "varchar(255) NULL COMMENT '身份证正面'",
            'cardReverse' => "varchar(255) NULL COMMENT '身份证反面'",
            'interior' => "varchar(255) NULL COMMENT '店铺内景'",
            'wechat_code' => "varchar(255) NULL COMMENT '微信二维码'",
            'certification' => "varchar(255) NULL COMMENT '其他资质'",
            'status' => "int(11) NULL COMMENT '店铺审核状态'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_store}}',['id'=>'1','member_id'=>'2','name'=>'12','mobile'=>'13892893894','address'=>'12','city'=>'802','provice'=>'801','area'=>'801','desc'=>'2','linkman'=>'12','storefront'=>'202207/18/1091b64a-8095-3808-b51a-d07880d027cd.jpg','business'=>'202207/18/8638e759-a144-3b48-91ee-85c1ddddb053.jpg','cardFront'=>'202207/18/408bbf99-846d-34d2-8c0a-cdf263bf2bf3.jpg','cardReverse'=>'202207/18/40ead5e4-2686-3f42-9d8c-0b3cb6890364.jpg','interior'=>'202207/18/613bc5c0-b1a7-36ae-899b-51d0de0d6e19.jpg','wechat_code'=>'202207/18/bfed1bda-07f4-32d3-86a5-d29b384cc8c0.jpg','certification'=>'202207/18/2bb46b3f-9984-33c7-a036-381536aff6ab.jpg','status'=>'0','create_time'=>'1658126942','update_time'=>'1658126942']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

