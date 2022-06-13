<?php

use yii\db\Migration;

class m220613_055820_core_paylog extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%core_paylog}}', [
            'plid' => "bigint(11) unsigned NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'type' => "varchar(20) NOT NULL COMMENT '支付类型'",
            'openid' => "varchar(40) NULL COMMENT 'openid'",
            'member_id' => "int(11) NULL",
            'uniontid' => "varchar(64) NULL COMMENT '跨应用标识'",
            'tid' => "varchar(128) NULL",
            'fee' => "decimal(10,2) NOT NULL COMMENT '支付金额'",
            'status' => "tinyint(4) NOT NULL COMMENT '支付状态'",
            'module' => "varchar(50) NOT NULL COMMENT '模块'",
            'tag' => "varchar(2000) NOT NULL",
            'is_usecard' => "tinyint(3) unsigned NULL COMMENT '是否使用会员卡'",
            'card_type' => "tinyint(3) unsigned NULL COMMENT '会员卡类型'",
            'card_id' => "varchar(50) NULL COMMENT '会员卡id'",
            'card_fee' => "decimal(10,2) unsigned NULL COMMENT '会员卡余额'",
            'encrypt_code' => "varchar(100) NULL COMMENT '加密字符串'",
            'is_wish' => "tinyint(11) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`plid`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('idx_openid','{{%core_paylog}}','openid',0);
        $this->createIndex('idx_tid','{{%core_paylog}}','tid',0);
        $this->createIndex('uniontid','{{%core_paylog}}','uniontid',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%core_paylog}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

