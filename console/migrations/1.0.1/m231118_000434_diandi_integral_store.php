<?php

use yii\db\Migration;

class m231118_000434_diandi_integral_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '所属公司'",
            'title' => "varchar(50) NULL COMMENT '商家名称'",
            'banner' => "varchar(255) NULL COMMENT '横幅背景'",
            'distance' => "int(11) NULL COMMENT '配送范围'",
            'logo' => "varchar(255) NULL COMMENT '商家logo'",
            'intro' => "varchar(255) NULL COMMENT '简介'",
            'address' => "varchar(255) NOT NULL COMMENT '商家地址'",
            'shareimg' => "varchar(255) NULL COMMENT '分享图片'",
            'certificate' => "varchar(255) NULL COMMENT '资质证书'",
            'hotSearch' => "varchar(255) NULL COMMENT '热搜'",
            'lng_lat' => "varchar(255) NULL COMMENT '经纬度'",
            'service' => "varchar(255) NULL COMMENT '服务'",
            'mobile' => "bigint(20) NULL COMMENT '商家电话'",
            'sendtime' => "varchar(100) NULL COMMENT '配送时间'",
            'Lodop_ip' => "varchar(100) NULL COMMENT '打印机IP'",
            'shippingDees' => "decimal(10,0) NULL COMMENT '基础配送费'",
            'notice' => "varchar(255) NULL COMMENT '公告'",
            'surroundings' => "varchar(255) NULL COMMENT '商家环境'",
            'startingPrice' => "decimal(10,0) NULL COMMENT '起送价'",
            'describe' => "varchar(255) NULL COMMENT '商家详情'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('bloc_id','{{%diandi_integral_store}}','bloc_id',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

