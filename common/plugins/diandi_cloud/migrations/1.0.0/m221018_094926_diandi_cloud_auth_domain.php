<?php

use yii\db\Migration;

class m221018_094926_diandi_cloud_auth_domain extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_cloud_auth_domain}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'status' => "int(11) NULL COMMENT '域名状态'",
            'domin_url' => "varchar(100) NULL COMMENT '域名'",
            'start_time' => "datetime NULL COMMENT '开始时间'",
            'end_time' => "datetime NULL COMMENT '结束时间'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_cloud_auth_domain}}',['id'=>'1','member_id'=>'1','status'=>'1','domin_url'=>'http://asdas.com','start_time'=>'1996-06-20 12:22:11','end_time'=>'2022-07-30 12:22:23','create_time'=>'1657521683','update_time'=>'1657521714']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_cloud_auth_domain}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

