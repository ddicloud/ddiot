<?php

use yii\db\Migration;

class m231118_154944_diandi_tea_invoice extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_invoice}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'status' => "tinyint(3) NULL COMMENT '是否开票: 1.已开  2.未开'",
            'invoice_url' => "text NULL COMMENT '发票文件地址'",
            'company' => "varchar(100) NULL COMMENT '公司名称'",
            'social_code' => "varchar(100) NULL COMMENT '社会统一代码'",
            'phone' => "varchar(100) NULL COMMENT '电话'",
            'email' => "varchar(100) NULL COMMENT '邮箱'",
            'member_id' => "int(11) NULL COMMENT '用户ID'",
            'type' => "int(11) NULL COMMENT '发票类型1.订单发票 2.充值发票'",
            'bank' => "varchar(255) NULL COMMENT '银行账号'",
            'bank_address' => "varchar(255) NULL COMMENT '银行开户地'",
            'company_address' => "varchar(255) NULL COMMENT '公司地址'",
            'taxpayer_no' => "varchar(255) NULL COMMENT '纳税人识别号'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单开票'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_invoice}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

