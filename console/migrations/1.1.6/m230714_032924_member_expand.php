<?php

use yii\db\Migration;

class m230714_032924_member_expand extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member_expand}}', [
            'member_id' => "int(11) NOT NULL COMMENT '会员ID'",
            'admin_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID'",
            'is_developer' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '是否是开发者'",
            'cert_gold' => "decimal(10,2) NOT NULL COMMENT '认证金'",
            'cert_gold_status' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '认证金支付状态'",
            'pay_at' => "datetime NULL COMMENT '支付时间'",
            'pay_no' => "varchar(50) NOT NULL COMMENT '认证金支付单号'",
            'cert_type' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '认证类型（审核通过）'",
            'cert_status' => "tinyint(2) NOT NULL DEFAULT '-1' COMMENT '认证状态'",
            'id_card_front' => "varchar(90) NOT NULL DEFAULT '' COMMENT '身份证正面照'",
            'id_card_reverse' => "varchar(90) NOT NULL DEFAULT '' COMMENT '身份证反面照'",
            'id_card_expired_at' => "date NULL COMMENT '身份证件过期时间'",
            'license' => "varchar(90) NOT NULL DEFAULT '' COMMENT '营业执照照片'",
            'audit' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '（个人或者企业信息）审核状态'",
            'audit_type' => "tinyint(2) NOT NULL DEFAULT '1' COMMENT '待审核认证类型'",
            'audit_opinion' => "varchar(255) NOT NULL DEFAULT '' COMMENT '审核意见'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'PRIMARY KEY (`member_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='开发者扩展表'");
        
        /* 索引设置 */
        $this->createIndex('UNIQUE_PAY_NO','{{%member_expand}}','pay_no',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member_expand}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

