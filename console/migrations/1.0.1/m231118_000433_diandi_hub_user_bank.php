<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_user_bank extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_user_bank}}', [
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
        $this->createIndex('member_id','{{%diandi_hub_user_bank}}','member_id',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_user_bank}}',['id'=>'1','member_id'=>'1','name'=>'','bank_no'=>'2','mobile'=>'2','address'=>'2','province'=>'2','city'=>'2','area'=>'2','thumb'=>'202203/01/5448e526-5fcf-3fe0-8e2d-53c02ad1717b.jpg','card_front'=>'202203/01/403a8c39-48c0-31ef-be95-f405fd8852b2.jpg','card_reverse'=>NULL,'alipay'=>'2','is_apply'=>'0','editor_status'=>'0','create_time'=>'1646127546','update_time'=>'1646127546']);
        $this->insert('{{%diandi_hub_user_bank}}',['id'=>'3','member_id'=>'0','name'=>'','bank_no'=>'','mobile'=>'0','address'=>'0','province'=>'0','city'=>NULL,'area'=>NULL,'thumb'=>NULL,'card_front'=>NULL,'card_reverse'=>NULL,'alipay'=>NULL,'is_apply'=>'0','editor_status'=>'0','create_time'=>'1646127933','update_time'=>'1646127933']);
        $this->insert('{{%diandi_hub_user_bank}}',['id'=>'4','member_id'=>'58','name'=>'yao','bank_no'=>'233333','mobile'=>'12384758736','address'=>'2323','province'=>'19','city'=>'20','area'=>'27','thumb'=>'202204/12/6c008702-9ac0-3fcf-8827-393476b6c457.jpeg','card_front'=>'202204/12/24672e27-5a5a-36d5-b714-22be18db2d78.jpeg','card_reverse'=>'202204/12/50573346-1336-35d7-9e79-9fb9f5a02495.jpeg','alipay'=>'233333333333','is_apply'=>'1','editor_status'=>'1','create_time'=>'1649749904','update_time'=>'1649749904']);
        $this->insert('{{%diandi_hub_user_bank}}',['id'=>'5','member_id'=>'11395','name'=>'12','bank_no'=>'222','mobile'=>'11111111111','address'=>'12','province'=>'585','city'=>'597','area'=>'601','thumb'=>'202205/05/7c2537ad-78ec-3357-9524-570e55f3002b.png','card_front'=>'202205/05/a48651ea-72be-3261-9131-13a6a3d14839.png','card_reverse'=>'202205/05/9a5cab03-d6c6-328e-b2bd-3e5bfd850881.png','alipay'=>'22222','is_apply'=>'0','editor_status'=>'1','create_time'=>'1651739793','update_time'=>'1651739793']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_user_bank}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

