<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-28 18:52:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 19:53:57
 */


use yii\db\Migration;

class m220628_105253_api_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_access_token}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'refresh_token' => "varchar(60) NULL DEFAULT '' COMMENT '刷新令牌'",
            'access_token' => "varchar(60) NULL DEFAULT '' COMMENT '授权令牌'",
            'member_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '用户id'",
            'openid' => "varchar(50) NULL DEFAULT '' COMMENT '授权对象openid'",
            'group_id' => "varchar(100) NULL DEFAULT '' COMMENT '组别'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'create_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'login_num' => "int(11) NULL DEFAULT '0' COMMENT '登录次数'",
            'allowance' => "int(11) NULL",
            'allowance_updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%api_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%api_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

