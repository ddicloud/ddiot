<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_view extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_view}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'start_time' => "datetime NULL COMMENT '开始浏览时间'",
            'end_time' => "datetime NULL COMMENT '离开时间'",
            'fanid' => "int(11) NULL COMMENT '粉丝ID'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='活动统一规则'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'3','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'1','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'4','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'2','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'5','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'3','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'6','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'4','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'7','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'5','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'8','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'3','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'6','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'9','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'7','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'10','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'11','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'1','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'12','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'13','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'14','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'15','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        $this->insert('{{%bea_cloud_activity_view}}',['id'=>'16','store_id'=>'137','bloc_id'=>'38','create_time'=>NULL,'update_time'=>NULL,'activity_type'=>'2','activity_id'=>'1','start_time'=>NULL,'end_time'=>NULL,'fanid'=>'8','member_id'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_view}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

