<?php

use yii\db\Migration;

class m220613_090925_diandi_tea_member_coupon extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_member_coupon}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员卡券id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'coupon_name' => "varchar(100) NOT NULL COMMENT '卡券名称'",
            'coupon_type' => "smallint(6) NULL COMMENT '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券'",
            'coupon_id' => "int(11) NULL COMMENT '卡券id'",
            'buy_time' => "datetime NULL COMMENT '购买时间'",
            'end_time' => "datetime NULL COMMENT '到期时间'",
            'use_time' => "datetime NULL COMMENT '使用时间'",
            'use_num' => "smallint(6) NULL DEFAULT '0' COMMENT '使用次数'",
            'surplus_num' => "smallint(6) NULL DEFAULT '0' COMMENT '剩余次数'",
            'receive_type' => "smallint(6) NULL COMMENT '领取方式：1.领取 2.购买 3.充值赠送'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户卡券表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'56','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 08:31:59','update_time'=>'2022-06-08 08:31:59','member_id'=>'11300','coupon_name'=>'2元券','coupon_type'=>'1','coupon_id'=>'9','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'57','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 08:36:45','update_time'=>'2022-06-08 08:36:45','member_id'=>'11624','coupon_name'=>'2元券','coupon_type'=>'1','coupon_id'=>'9','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'58','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 16:46:52','update_time'=>'2022-06-08 16:46:52','member_id'=>'11254','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'6','surplus_num'=>'11','receive_type'=>'2']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'59','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 11:01:13','update_time'=>'2022-06-09 11:01:13','member_id'=>'11301','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'1','surplus_num'=>'0','receive_type'=>'2']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'60','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 11:08:48','update_time'=>'2022-06-09 11:08:48','member_id'=>'11301','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'61','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 11:33:26','update_time'=>'2022-06-09 11:33:26','member_id'=>'4949','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'2']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'62','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 11:43:32','update_time'=>'2022-06-09 11:43:32','member_id'=>'11254','coupon_name'=>'体验','coupon_type'=>'5','coupon_id'=>'5','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'2']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'63','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 14:34:31','update_time'=>'2022-06-09 14:34:31','member_id'=>'11629','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'64','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 17:49:09','update_time'=>'2022-06-09 17:49:09','member_id'=>'11296','coupon_name'=>'3元代金券','coupon_type'=>'3','coupon_id'=>'8','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'65','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-09 18:16:38','update_time'=>'2022-06-09 18:16:38','member_id'=>'11296','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'3','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'66','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-10 00:05:43','update_time'=>'2022-06-10 00:05:43','member_id'=>'11632','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'67','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 14:20:54','update_time'=>'2022-06-12 14:20:54','member_id'=>'11647','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'68','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 15:57:03','update_time'=>'2022-06-12 15:57:03','member_id'=>'11650','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'69','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 16:28:40','update_time'=>'2022-06-12 16:28:40','member_id'=>'11654','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'70','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 17:42:05','update_time'=>'2022-06-12 17:42:05','member_id'=>'11655','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'71','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 17:42:09','update_time'=>'2022-06-12 17:42:09','member_id'=>'11656','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        $this->insert('{{%diandi_tea_member_coupon}}',['id'=>'72','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-12 19:40:35','update_time'=>'2022-06-12 19:40:35','member_id'=>'11657','coupon_name'=>'时长卡','coupon_type'=>'2','coupon_id'=>'7','buy_time'=>NULL,'end_time'=>NULL,'use_time'=>NULL,'use_num'=>'0','surplus_num'=>'1','receive_type'=>'3']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_member_coupon}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

