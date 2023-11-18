<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_user_bank extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_user_bank}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id'",
            'name' => "varchar(30) NOT NULL DEFAULT '' COMMENT '用户姓名'",
            'bank_no' => "varchar(50) NOT NULL DEFAULT '' COMMENT '银行卡号'",
            'mobile' => "varchar(11) NOT NULL DEFAULT '0' COMMENT '到账通知手机号'",
            'address' => "varchar(50) NOT NULL DEFAULT '0' COMMENT '开户行'",
            'province' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份'",
            'city' => "int(11) NULL COMMENT '城市'",
            'area' => "int(11) NULL COMMENT '区域'",
            'thumb' => "varchar(255) NULL COMMENT '银行卡正面照片'",
            'card_front' => "varchar(255) NULL COMMENT '身份证正面'",
            'card_reverse' => "varchar(255) NULL COMMENT '身份证反面'",
            'alipay' => "varchar(255) NULL COMMENT '支付宝账号'",
            'is_apply' => "int(11) NULL DEFAULT '0'",
            'editor_status' => "int(11) NULL DEFAULT '1' COMMENT '0正常1禁止修改'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_user_bank}}','member_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_user_bank}}',['id'=>'1','member_id'=>'2','name'=>'1','bank_no'=>'1','mobile'=>'1','address'=>'1','province'=>'801','city'=>'802','area'=>'813','thumb'=>'202207/13/8214791b-9278-3f08-9e7c-a5c78d051f71.png','card_front'=>'202207/13/25b44428-fe79-35c5-b1d9-4d817dcbd2bf.png','card_reverse'=>'202207/13/003e6dcb-b552-32ef-8c5b-a84cce70d464.png','alipay'=>'','is_apply'=>'1','editor_status'=>'1','create_time'=>'1657696695','update_time'=>'1657696695']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_user_bank}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

