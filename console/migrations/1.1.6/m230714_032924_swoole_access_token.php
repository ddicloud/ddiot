<?php

use yii\db\Migration;

class m230714_032924_swoole_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%swoole_access_token}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'refresh_token' => "varchar(60) NULL DEFAULT '' COMMENT '刷新令牌'",
            'access_token' => "varchar(60) NULL DEFAULT '' COMMENT '授权令牌'",
            'swoole_member_id' => "int(11) NULL COMMENT 'swoole会员ID'",
            'member_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '用户id'",
            'openid' => "varchar(50) NULL DEFAULT '' COMMENT '授权对象openid'",
            'group_id' => "int(11) NULL COMMENT '组别'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'create_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'login_num' => "int(11) NULL DEFAULT '0' COMMENT '登录次数'",
            'allowance' => "int(11) NULL",
            'allowance_updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%swoole_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%swoole_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%swoole_access_token}}',['id'=>'1','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1663553983','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1664435667','swoole_member_id'=>'1','member_id'=>'1','openid'=>'','group_id'=>'1','bloc_id'=>'8','store_id'=>'85','status'=>'1','create_time'=>'0','updated_time'=>'0','login_num'=>'589','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%swoole_access_token}}',['id'=>'2','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666411927','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666873057','swoole_member_id'=>'3','member_id'=>'0','openid'=>'','group_id'=>'1','bloc_id'=>'8','store_id'=>'85','status'=>'1','create_time'=>'1660900012','updated_time'=>'0','login_num'=>'4128','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%swoole_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

