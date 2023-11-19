<?php

use yii\db\Migration;

class m231118_154945_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member}}', [
            'member_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'group_id' => "int(11) NOT NULL",
            'level' => "int(11) NULL",
            'openid' => "varchar(255) NOT NULL DEFAULT ''",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NOT NULL",
            'username' => "varchar(30) NULL COMMENT '会员名称'",
            'mobile' => "varchar(11) NULL COMMENT '手机号'",
            'address' => "varchar(255) NULL COMMENT '用户地址'",
            'nickName' => "varchar(255) NOT NULL DEFAULT '' COMMENT '微信昵称'",
            'avatarUrl' => "varchar(255) NOT NULL DEFAULT '' COMMENT '会员头像'",
            'gender' => "tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0男1女'",
            'country' => "varchar(100) NOT NULL DEFAULT '' COMMENT '国家'",
            'province' => "varchar(100) NOT NULL DEFAULT '' COMMENT '省份'",
            'status' => "int(11) NULL DEFAULT '0' COMMENT '会员状态'",
            'city' => "varchar(100) NOT NULL DEFAULT '' COMMENT '城市'",
            'address_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址id'",
            'invitation_code' => "varchar(100) NOT NULL DEFAULT '0'",
            'verification_token' => "varchar(255) NULL COMMENT '验证token'",
            'create_time' => "bigint(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "bigint(11) unsigned NOT NULL DEFAULT '0'",
            'auth_key' => "varchar(32) NOT NULL",
            'password_hash' => "varchar(255) NOT NULL",
            'password_reset_token' => "varchar(255) NULL",
            'realname' => "varchar(10) NULL COMMENT '真实姓名'",
            'avatar' => "varchar(255) NULL COMMENT '头像'",
            'qq' => "varchar(10) NULL COMMENT 'QQ号'",
            'vip' => "varchar(10) NULL COMMENT 'VIP级别'",
            'birthyear' => "varchar(10) NULL COMMENT '出生生日'",
            'constellation' => "varchar(10) NULL COMMENT '星座'",
            'zodiac' => "varchar(10) NULL COMMENT '生肖'",
            'telephone' => "varchar(10) NULL COMMENT '固定电话'",
            'idcard' => "varchar(20) NULL COMMENT '证件号码'",
            'studentid' => "varchar(10) NULL COMMENT '学号'",
            'grade' => "varchar(10) NULL COMMENT '班级'",
            'zipcode' => "varchar(10) NULL COMMENT '邮编'",
            'nationality' => "varchar(10) NULL COMMENT '国籍'",
            'resideprovince' => "varchar(10) NULL COMMENT '居住地址'",
            'graduateschool' => "varchar(10) NULL COMMENT '毕业学校'",
            'company' => "varchar(10) NULL COMMENT '公司'",
            'education' => "varchar(10) NULL COMMENT '学历'",
            'occupation' => "varchar(10) NULL COMMENT '职业'",
            'position' => "varchar(10) NULL COMMENT '职位'",
            'revenue' => "varchar(10) NULL COMMENT '年收入'",
            'affectivestatus' => "varchar(10) NULL COMMENT '情感状态'",
            'lookingfor' => "varchar(10) NULL COMMENT ' 交友目的'",
            'bloodtype' => "varchar(10) NULL COMMENT '血型'",
            'height' => "varchar(10) NULL COMMENT '身高'",
            'weight' => "varchar(10) NULL COMMENT '体重'",
            'alipay' => "varchar(10) NULL COMMENT '支付宝帐号'",
            'msn' => "varchar(10) NULL COMMENT 'MSN'",
            'email' => "varchar(10) NULL COMMENT '电子邮箱'",
            'taobao' => "varchar(10) NULL COMMENT '阿里旺旺'",
            'site' => "varchar(10) NULL COMMENT '主页'",
            'bio' => "varchar(10) NULL COMMENT '自我介绍'",
            'interest' => "varchar(10) NULL COMMENT '兴趣爱好'",
            'organization_id' => "int(11) NULL COMMENT '组织机构ID'",
            'PRIMARY KEY (`member_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('openid','{{%member}}','openid',0);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

