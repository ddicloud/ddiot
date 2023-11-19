<?php

use yii\db\Migration;

class m231118_154943_bloc_conf_wechatpay extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_wechatpay}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(10) unsigned NOT NULL COMMENT '公司ID'",
            'mch_id' => "varchar(255) NOT NULL COMMENT '商户ID'",
            'app_id' => "varchar(255) NOT NULL DEFAULT '0' COMMENT 'APPID'",
            'key' => "varchar(255) NOT NULL DEFAULT '0' COMMENT '支付密钥'",
            'notify_url' => "varchar(255) NOT NULL COMMENT '回调地址'",
            'is_server' => "int(11) NULL COMMENT '是否开启服务商模式'",
            'server_mchid' => "varchar(255) NULL COMMENT '服务商商户号'",
            'server_signkey' => "varchar(255) NULL COMMENT '服务商秘钥'",
            'apiclient_cert' => "text NULL",
            'apiclient_key' => "text NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bloc_conf_wechatpay}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

