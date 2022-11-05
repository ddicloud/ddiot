<?php

use yii\db\Migration;

class m221105_121058_bloc_conf_oss extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bloc_conf_oss}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(10) unsigned NOT NULL COMMENT '公司ID'",
            'remote_type' => "varchar(255) NULL",
            'Aliyunoss_accessKeyId' => "varchar(255) NULL DEFAULT '0'",
            'Aliyunoss_resource' => "varchar(255) NULL DEFAULT '0'",
            'Aliyunoss_accessKeySecret' => "varchar(255) NULL",
            'Aliyunoss_bucket' => "varchar(255) NULL",
            'Aliyunoss_url' => "varchar(255) NULL",
            'Aliyunoss_endPoint' => "varchar(255) NULL",
            'Tengxunoss_APPID' => "varchar(255) NULL",
            'Tengxunoss_SecretID' => "varchar(255) NULL",
            'Tengxunoss_SecretKEY' => "varchar(255) NULL",
            'Tengxunoss_Bucket' => "varchar(255) NULL",
            'Tengxunoss_area' => "varchar(255) NULL",
            'Tengxunoss_url' => "varchar(255) NULL",
            'Qiniuoss_Accesskey' => "varchar(255) NULL",
            'Qiniuoss_Secretkey' => "varchar(255) NULL",
            'Qiniuoss_Bucket' => "varchar(255) NULL",
            'Qiniuoss_url' => "varchar(255) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
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
        $this->dropTable('{{%bloc_conf_oss}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

