<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_track extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_track}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'activity_type' => "int(11) NULL COMMENT '活动类型'",
            'activity_id' => "int(11) NULL COMMENT '活动ID'",
            'track_type' => "int(11) NULL COMMENT '轨迹类型'",
            'track_num' => "int(11) NULL COMMENT '行为次数'",
            'share_member_id' => "int(11) NULL COMMENT '被分享人ID'",
            'is_pay' => "int(11) NULL COMMENT '是否付款'",
            'fanid' => "int(11) NULL COMMENT '粉丝ID'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='用户轨迹'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'1','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 19:29:04','update_time'=>'2023-03-20 19:29:04','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'2','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 19:29:13','update_time'=>'2023-03-20 19:29:13','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'3','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 19:41:48','update_time'=>'2023-03-23 11:53:38','activity_type'=>'5','activity_id'=>'11','track_type'=>'3','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'4','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 19:47:36','update_time'=>'2023-03-23 14:35:18','activity_type'=>'1','activity_id'=>'2','track_type'=>'2','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'5','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 19:47:37','update_time'=>'2023-03-20 19:47:37','activity_type'=>'1','activity_id'=>'2','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'6','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 19:53:33','update_time'=>'2023-03-23 20:29:30','activity_type'=>'1','activity_id'=>'4','track_type'=>'2','track_num'=>'7','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'7','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:01:16','update_time'=>'2023-03-23 22:14:58','activity_type'=>'5','activity_id'=>'11','track_type'=>'3','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'8','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:01:20','update_time'=>'2023-03-20 20:01:20','activity_type'=>'1','activity_id'=>'4','track_type'=>'2','track_num'=>'7','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'9','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:01:45','update_time'=>'2023-03-20 20:01:45','activity_type'=>'1','activity_id'=>'4','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'10','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:02:15','update_time'=>'2023-03-20 20:02:15','activity_type'=>'1','activity_id'=>'4','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'11','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:08','update_time'=>'2023-03-20 20:11:08','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'12','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:21','update_time'=>'2023-03-20 20:11:21','activity_type'=>'1','activity_id'=>'2','track_type'=>'2','track_num'=>'4','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'13','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:22','update_time'=>'2023-03-20 20:11:22','activity_type'=>'1','activity_id'=>'2','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'14','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:35','update_time'=>'2023-03-20 20:11:35','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'15','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:38','update_time'=>'2023-03-23 21:44:34','activity_type'=>'1','activity_id'=>'6','track_type'=>'2','track_num'=>'154','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'16','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:11:39','update_time'=>'2023-03-23 21:29:02','activity_type'=>'1','activity_id'=>'6','track_type'=>'3','track_num'=>'48','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'20','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:40:31','update_time'=>'2023-03-23 22:36:51','activity_type'=>'1','activity_id'=>'6','track_type'=>'2','track_num'=>'26','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'19','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:39:08','update_time'=>'2023-03-20 20:39:08','activity_type'=>'1','activity_id'=>'6','track_type'=>'1','track_num'=>'19','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'21','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 20:40:39','update_time'=>'2023-03-22 20:21:50','activity_type'=>'1','activity_id'=>'6','track_type'=>'1','track_num'=>'4','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'22','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-20 20:58:45','update_time'=>'2023-03-20 20:58:45','activity_type'=>'1','activity_id'=>'2','track_type'=>'1','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'23','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 09:15:52','update_time'=>'2023-03-23 15:42:02','activity_type'=>'2','activity_id'=>'8','track_type'=>'2','track_num'=>'62','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'24','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 09:15:56','update_time'=>'2023-03-21 09:15:56','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'25','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 09:15:58','update_time'=>'2023-03-23 19:29:27','activity_type'=>'5','activity_id'=>'11','track_type'=>'3','track_num'=>'4','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'26','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 09:17:51','update_time'=>'2023-03-23 15:39:44','activity_type'=>'1','activity_id'=>'4','track_type'=>'2','track_num'=>'79','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'27','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:01:56','update_time'=>'2023-03-23 21:07:07','activity_type'=>'3','activity_id'=>'12','track_type'=>'2','track_num'=>'19','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'28','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:01:56','update_time'=>'2023-03-24 10:14:06','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>NULL,'member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'29','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:11:49','update_time'=>'2023-03-23 16:14:04','activity_type'=>'5','activity_id'=>'11','track_type'=>'3','track_num'=>'4','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'30','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:12:08','update_time'=>'2023-03-24 11:19:35','activity_type'=>'2','activity_id'=>'8','track_type'=>'2','track_num'=>'13','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'31','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:13:33','update_time'=>'2023-03-21 10:13:33','activity_type'=>'2','activity_id'=>'8','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'32','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:44:05','update_time'=>'2023-03-24 11:19:17','activity_type'=>'3','activity_id'=>'12','track_type'=>'2','track_num'=>'15','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'33','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-21 10:44:43','update_time'=>'2023-03-24 11:19:30','activity_type'=>'1','activity_id'=>'4','track_type'=>'2','track_num'=>'50','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'34','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-21 18:19:51','update_time'=>'2023-03-21 18:19:51','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'35','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 09:13:42','update_time'=>'2023-03-22 09:13:42','activity_type'=>'3','activity_id'=>'12','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'36','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 09:27:26','update_time'=>'2023-03-22 09:27:26','activity_type'=>'1','activity_id'=>'4','track_type'=>'1','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'37','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 09:31:16','update_time'=>'2023-03-22 09:31:16','activity_type'=>'1','activity_id'=>'8','track_type'=>'1','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'38','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 09:56:05','update_time'=>'2023-03-22 09:56:05','activity_type'=>'1','activity_id'=>'12','track_type'=>'1','track_num'=>'5','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'39','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 11:09:19','update_time'=>'2023-03-22 11:09:19','activity_type'=>'3','activity_id'=>'12','track_type'=>'2','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'40','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 11:09:23','update_time'=>'2023-03-22 11:09:23','activity_type'=>'1','activity_id'=>'12','track_type'=>'1','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'41','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-22 11:35:17','update_time'=>'2023-03-23 21:03:47','activity_type'=>'1','activity_id'=>'6','track_type'=>'2','track_num'=>'40','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'42','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-22 16:05:04','update_time'=>'2023-03-23 21:04:20','activity_type'=>'1','activity_id'=>'6','track_type'=>'3','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'43','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-22 20:48:12','update_time'=>'2023-03-23 21:29:06','activity_type'=>'1','activity_id'=>'6','track_type'=>'4','track_num'=>'91','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'44','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-23 14:17:24','update_time'=>'2023-03-23 14:17:24','activity_type'=>'1','activity_id'=>'2','track_type'=>'2','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'45','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 16:24:20','update_time'=>'2023-03-23 21:04:16','activity_type'=>'1','activity_id'=>'6','track_type'=>'1','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'85','member_id'=>'123']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'46','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-23 20:00:32','update_time'=>'2023-03-23 20:00:32','activity_type'=>'1','activity_id'=>'6','track_type'=>'4','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'90','member_id'=>'128']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'47','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:58:57','update_time'=>'2023-03-23 21:57:26','activity_type'=>'2','activity_id'=>'9','track_type'=>'2','track_num'=>'11','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'48','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:59:01','update_time'=>'2023-03-23 21:58:30','activity_type'=>'2','activity_id'=>'9','track_type'=>'3','track_num'=>'6','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'49','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:59:20','update_time'=>'2023-03-23 21:56:23','activity_type'=>'2','activity_id'=>'9','track_type'=>'2','track_num'=>'17','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'50','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:59:21','update_time'=>'2023-03-23 21:47:07','activity_type'=>'2','activity_id'=>'9','track_type'=>'3','track_num'=>'4','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'51','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:08:47','update_time'=>'2023-03-23 21:47:13','activity_type'=>'2','activity_id'=>'9','track_type'=>'4','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'52','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 21:13:01','update_time'=>'2023-03-23 21:13:01','activity_type'=>'1','activity_id'=>'6','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'53','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 22:39:03','update_time'=>'2023-03-24 11:12:02','activity_type'=>'3','activity_id'=>'13','track_type'=>'2','track_num'=>'18','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'54','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 22:39:26','update_time'=>'2023-03-24 10:30:56','activity_type'=>'3','activity_id'=>'13','track_type'=>'2','track_num'=>'3','share_member_id'=>'0','is_pay'=>'0','fanid'=>'84','member_id'=>'108']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'55','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-24 10:09:58','update_time'=>'2023-03-24 10:09:58','activity_type'=>'5','activity_id'=>'12','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'56','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-24 10:14:06','update_time'=>'2023-03-24 10:14:06','activity_type'=>'0','activity_id'=>'0','track_type'=>'0','track_num'=>'2','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'57','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-24 10:14:10','update_time'=>'2023-03-24 11:19:51','activity_type'=>'3','activity_id'=>'13','track_type'=>'2','track_num'=>'56','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'58','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-24 11:12:05','update_time'=>'2023-03-24 11:12:05','activity_type'=>'3','activity_id'=>'13','track_type'=>'3','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'86','member_id'=>'124']);
        $this->insert('{{%bea_cloud_activity_track}}',['id'=>'59','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-24 11:19:42','update_time'=>'2023-03-24 11:19:42','activity_type'=>'1','activity_id'=>'6','track_type'=>'2','track_num'=>'1','share_member_id'=>'0','is_pay'=>'0','fanid'=>'72','member_id'=>'90']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_track}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

