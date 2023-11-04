<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_store_staff_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_store_staff_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'staff_code' => "varchar(50) NULL COMMENT '员工编码'",
            'mobile' => "varchar(50) NULL COMMENT '手机号'",
            'status' => "int(11) NULL COMMENT '状态'",
            'old_store_id' => "int(11) NULL COMMENT '原门店'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='员工'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_store_staff_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

