<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_member_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_member_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'is_store' => "int(11) NOT NULL DEFAULT '0' COMMENT '是否是员工'",
            'member_store_id' => "int(11) NOT NULL COMMENT '我的店铺'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'member_pid' => "int(11) NULL COMMENT '上级id'",
            'level_pid_num' => "int(11) NULL COMMENT '上级的等级'",
            'level_num' => "int(11) NULL COMMENT '等级'",
            'family' => "text NULL COMMENT '下级家族'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='会员关系'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%bea_cloud_member_level}}','member_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_member_level}}',['id'=>'24','bloc_id'=>'51','store_id'=>'150','is_store'=>'0','member_store_id'=>'999','member_id'=>'108','member_pid'=>'124','level_pid_num'=>'1','level_num'=>'1','family'=>'124','create_time'=>'2023-03-22 20:22:52','update_time'=>'2023-03-22 20:22:52']);
        $this->insert('{{%bea_cloud_member_level}}',['id'=>'25','bloc_id'=>'38','store_id'=>'138','is_store'=>'0','member_store_id'=>'999','member_id'=>'128','member_pid'=>'108','level_pid_num'=>'1','level_num'=>'1','family'=>'108,124','create_time'=>'2023-03-22 20:23:12','update_time'=>'2023-03-22 20:23:12']);
        $this->insert('{{%bea_cloud_member_level}}',['id'=>'26','bloc_id'=>'38','store_id'=>'138','is_store'=>'0','member_store_id'=>'0','member_id'=>'130','member_pid'=>'108','level_pid_num'=>'1','level_num'=>'1','family'=>'108,124','create_time'=>'2023-03-23 19:51:37','update_time'=>'2023-03-23 19:51:37']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_member_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

