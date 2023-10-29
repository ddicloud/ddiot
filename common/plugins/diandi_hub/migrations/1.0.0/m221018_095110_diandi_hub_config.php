<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_config}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'min_money' => "decimal(11,2) NULL COMMENT '用户最低提现金额'",
            'max_num' => "int(11) NULL COMMENT '用户每天最多提现次数'",
            'max_money' => "decimal(11,2) NULL COMMENT '用户每天最多提现金额'",
            'store_min_money' => "decimal(11,2) NULL COMMENT '商户最低提现金额'",
            'store_max_num' => "int(11) NULL COMMENT '商户每天最多提现次数'",
            'store_max_money' => "decimal(11,2) NULL COMMENT '商户每天最多提现金额'",
            'store_radio' => "decimal(11,2) NULL COMMENT '商户提现手续费'",
            'user_radio' => "decimal(11,2) NULL COMMENT '用户提现手续费'",
            'user_integral_name' => "varchar(30) NULL COMMENT '系统积分名称'",
            'is_credit1' => "int(11) NOT NULL DEFAULT '0' COMMENT '是否启用分销'",
            'is_credit2' => "int(11) NOT NULL DEFAULT '0' COMMENT '是否启用credit2'",
            'is_credit3' => "int(11) NOT NULL DEFAULT '0' COMMENT '是否启用credit3'",
            'credit1_name' => "varchar(30) NULL COMMENT 'credit1名称'",
            'credit2_name' => "varchar(255) NULL COMMENT 'credit2名称'",
            'credit3_name' => "varchar(255) NULL COMMENT 'credit3名称'",
            'kd_id' => "varchar(30) NULL COMMENT '快递鸟用户id'",
            'kd_key' => "varchar(100) NULL COMMENT '快递鸟key'",
            'onecode' => "int(11) NULL COMMENT '首码'",
            'shareimg' => "varchar(255) NULL COMMENT '分享图片'",
            'myshareimg' => "varchar(255) NULL COMMENT '我的海报背景'",
            'h5_url' => "varchar(255) NULL COMMENT 'h5发布地址'",
            'registration' => "text NULL COMMENT '注册协议'",
            'privacy' => "text NULL COMMENT '隐私协议'",
            'create_time' => "int(30) NULL",
            'update_time' => "int(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='商家评论'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_config}}',['id'=>'1','min_money'=>'0.00','max_num'=>'0','max_money'=>'0.00','store_min_money'=>'0.00','store_max_num'=>'0','store_max_money'=>'0.00','store_radio'=>'0.00','user_radio'=>'0.00','user_integral_name'=>'212','is_credit1'=>'1','is_credit2'=>'1','is_credit3'=>'1','credit1_name'=>'5665','credit2_name'=>'67674545','credit3_name'=>'2323','kd_id'=>'','kd_key'=>'','onecode'=>'0','shareimg'=>'202205/20/25b07114-6e56-3005-a8b9-b1d6db7c601c.png','myshareimg'=>'202205/20/78026d10-c4d7-3829-a92f-392302286a03.png','h5_url'=>'','registration'=>NULL,'privacy'=>NULL,'create_time'=>'1627696933','update_time'=>'1627696933']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

