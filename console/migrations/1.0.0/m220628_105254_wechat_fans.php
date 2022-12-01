<?php

use yii\db\Migration;

class m220628_105254_wechat_fans extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%wechat_fans}}', [
            'fanid' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '粉丝id'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'user_id' => "int(10) unsigned NOT NULL COMMENT '会员id'",
            'avatarUrl' => "varchar(255) NULL COMMENT '头像'",
            'openid' => "varchar(50) NOT NULL COMMENT 'OPENID'",
            'nickname' => "varchar(50) NOT NULL COMMENT '昵称'",
            'groupid' => "varchar(60) NULL COMMENT '分组id'",
            'fans_info' => "text NOT NULL COMMENT '所有资料'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'create_time' => "int(10) unsigned NULL COMMENT '创建时间'",
            'unionid' => "varchar(64) NOT NULL DEFAULT '' COMMENT 'unionid'",
            'gender' => "tinyint(4) NULL COMMENT '性别'",
            'country' => "varchar(30) NULL COMMENT '国家'",
            'city' => "varchar(30) NULL COMMENT '城市'",
            'province' => "varchar(30) NULL COMMENT '省份'",
            'secretKey' => "varchar(255) NULL COMMENT '加密键'",
            'follow' => "int(11) NULL DEFAULT '-1' COMMENT '1关注，-1未关注'",
            'followtime' => "datetime NULL COMMENT '关注时间'",
            'unfollowtime' => "datetime NULL COMMENT '取消关注时间'",
            'tag' => "varchar(255) NULL COMMENT '标签'",
            'PRIMARY KEY (`fanid`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公众号粉丝表'");
        
        /* 索引设置 */
        $this->createIndex('uid','{{%wechat_fans}}','user_id',0);
        $this->createIndex('openid','{{%wechat_fans}}','openid',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%wechat_fans}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

