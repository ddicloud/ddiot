<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_coupon extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_coupon}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '卡券id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'name' => "varchar(100) NOT NULL COMMENT '卡券名称'",
            'explain' => "varchar(255) NULL COMMENT '卡券说明'",
            'type' => "smallint(6) NULL COMMENT '卡券类型  1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券'",
            'price' => "decimal(10,2) NULL COMMENT '卡券价格'",
            'use_start' => "time NULL COMMENT '时间限制-开始时间'",
            'use_end' => "time NULL COMMENT '时间限制-结束时间'",
            'enable_start' => "datetime NULL COMMENT '有效期开始时间'",
            'enable_end' => "datetime NULL COMMENT '有效期结束时间'",
            'use_num' => "smallint(6) NULL COMMENT '已使用数量'",
            'max_time' => "varchar(100) NULL COMMENT '消费时长'",
            'enable_store' => "varchar(100) NULL COMMENT '适用店铺'",
            'enable_week' => "varchar(255) NULL COMMENT '适用星期(分别对应1~7）'",
            'third_party' => "varchar(100) NULL COMMENT '第三方编号'",
            'all_num' => "int(11) NULL COMMENT '总发放量'",
            'max_num' => "int(11) NULL COMMENT '最多可购买数量'",
            'background' => "varchar(255) NULL COMMENT '卡券背景图'",
            'cash' => "decimal(10,2) NULL COMMENT '代金券金额'",
            'discount' => "float NULL COMMENT '折扣券折扣'",
            'coupon_img' => "varchar(255) NULL COMMENT '卡券图片'",
            'use_hourse' => "varchar(255) NULL COMMENT '使用房间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='套餐表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'5','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:34:53','update_time'=>'2022-06-09 18:11:02','name'=>'体验券','explain'=>'体验券','type'=>'5','price'=>'10.00','use_start'=>'07:00:00','use_end'=>'21:30:00','enable_start'=>'2022-03-25 16:23:26','enable_end'=>'2050-03-26 16:23:28','use_num'=>'1','max_time'=>'2','enable_store'=>'','enable_week'=>'1','third_party'=>'123','all_num'=>'0','max_num'=>'1','background'=>'202206/09/162de7b3-c33c-3566-826c-22d8cfddb003.png','cash'=>NULL,'discount'=>NULL,'coupon_img'=>'202206/09/e9b5fb87-1411-3c86-9ca4-f0180151e4d9.jpg','use_hourse'=>'9']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'6','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-25 16:23:41','update_time'=>'2022-06-02 18:22:42','name'=>'10元代金券','explain'=>'代金券','type'=>'1','price'=>'10.00','use_start'=>'07:00:00','use_end'=>'21:30:00','enable_start'=>'2022-03-25 16:23:26','enable_end'=>'2050-03-26 16:23:28','use_num'=>'1','max_time'=>'2','enable_store'=>'','enable_week'=>'1','third_party'=>'111111','all_num'=>'11','max_num'=>'4','background'=>'202203/25/7fa0705f-2ab4-389e-afb9-7140de792d5d.png','cash'=>'100.00','discount'=>'75','coupon_img'=>'202205/30/31775690-34f4-384d-a6f1-fab82a927131.jpg','use_hourse'=>'5,7,8,9,10,11']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'7','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-25 16:23:41','update_time'=>'2022-06-09 18:17:29','name'=>'时长卡','explain'=>'时长卡','type'=>'2','price'=>'100.00','use_start'=>'01:30:00','use_end'=>'23:00:00','enable_start'=>'2022-03-25 16:23:26','enable_end'=>'2050-03-26 16:23:28','use_num'=>'7','max_time'=>'1','enable_store'=>'','enable_week'=>'1','third_party'=>'111111','all_num'=>'22','max_num'=>'2','background'=>'202205/30/93fd549b-3308-34bd-a0a9-3b8104a05d2b.png','cash'=>'20.00','discount'=>'75','coupon_img'=>'202205/30/3b397374-febe-307e-a943-c3ce8f4f8e1c.jpg','use_hourse'=>'5,7,8,9,10,11']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'8','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-25 16:23:41','update_time'=>'2022-06-02 18:22:09','name'=>'3元代金券','explain'=>'次卡','type'=>'3','price'=>'3.00','use_start'=>'07:30:00','use_end'=>'21:00:00','enable_start'=>'2022-03-25 16:23:26','enable_end'=>'2050-03-26 16:23:28','use_num'=>'1','max_time'=>'2','enable_store'=>'','enable_week'=>'1','third_party'=>'111111','all_num'=>'5','max_num'=>'4','background'=>'202203/25/7fa0705f-2ab4-389e-afb9-7140de792d5d.png','cash'=>'3.00','discount'=>'75','coupon_img'=>'202205/30/fe41c222-b2a1-394b-be51-60d8642be1f3.jpg','use_hourse'=>'5,7,8,9,10,11']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'9','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-25 16:23:41','update_time'=>'2022-06-02 18:22:28','name'=>'2元券','explain'=>'折扣券','type'=>'1','price'=>'2.00','use_start'=>'07:30:00','use_end'=>'22:00:00','enable_start'=>'2022-03-25 16:23:26','enable_end'=>'2050-11-25 00:00:00','use_num'=>'1','max_time'=>'2','enable_store'=>'','enable_week'=>'1','third_party'=>'111111','all_num'=>'7','max_num'=>'3','background'=>'202203/25/7fa0705f-2ab4-389e-afb9-7140de792d5d.png','cash'=>'20.00','discount'=>'75','coupon_img'=>'','use_hourse'=>'5,7,8,9,10,11']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'10','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-05-28 18:04:10','update_time'=>'2022-06-02 18:22:24','name'=>'1元券','explain'=>'1元代金券','type'=>'1','price'=>'1.00','use_start'=>'00:30:00','use_end'=>'02:30:00','enable_start'=>'2022-05-28 18:03:34','enable_end'=>'2022-05-31 00:00:00','use_num'=>'1','max_time'=>'1','enable_store'=>'','enable_week'=>'1','third_party'=>'12345678','all_num'=>'14','max_num'=>'2','background'=>'202205/30/2e566925-594a-3662-bbe0-7f7ac5dff3d4.png','cash'=>'1.00','discount'=>'2','coupon_img'=>'202205/30/5fdb53e5-85c9-39ef-af58-6c0930ad8dcc.jpg','use_hourse'=>'5,7,8,9,10,11']);
        $this->insert('{{%diandi_tea_coupon}}',['id'=>'11','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-01 15:34:53','update_time'=>'2022-06-02 18:15:23','name'=>'折扣券','explain'=>'折扣券','type'=>'4','price'=>'20.00','use_start'=>'07:00:00','use_end'=>'23:30:00','enable_start'=>'2022-06-01 15:34:35','enable_end'=>'2029-11-15 00:00:00','use_num'=>NULL,'max_time'=>'','enable_store'=>'','enable_week'=>'1','third_party'=>'','all_num'=>NULL,'max_num'=>'12','background'=>'202206/01/20247e72-2b7c-378b-9713-fa7c3434e9cf.jpeg','cash'=>NULL,'discount'=>'95','coupon_img'=>'202206/01/5340ba97-e3a1-3852-85bd-802a84f7fa31.jpeg','use_hourse'=>'5,7,8,9,10,11']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_coupon}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

