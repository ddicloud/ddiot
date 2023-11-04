<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_set_meal_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_set_meal_list}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '套餐消费记录id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(100) NULL COMMENT '套餐名'",
            'duration' => "smallint(6) NULL COMMENT '套餐时长'",
            'price' => "decimal(10,2) NULL COMMENT '套餐价格'",
            'renew_price' => "decimal(10,2) NULL COMMENT '每半小时续费单价'",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'set_meal_id' => "int(11) NULL COMMENT '套餐id'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='套餐消费记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'184','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 18:49:40','update_time'=>'2022-06-08 18:49:40','title'=>'【单价58】2小时4人间套餐','duration'=>NULL,'price'=>'96.00','renew_price'=>'29.00','order_id'=>'464','set_meal_id'=>'3','member_id'=>'4949']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'187','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 19:07:05','update_time'=>'2022-06-08 19:07:05','title'=>'【单价58】2小时4人间套餐','duration'=>NULL,'price'=>'96.00','renew_price'=>'29.00','order_id'=>'467','set_meal_id'=>'3','member_id'=>'11296']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'188','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 19:14:24','update_time'=>'2022-06-08 19:14:24','title'=>'【单价58】2小时4人间套餐','duration'=>NULL,'price'=>'96.00','renew_price'=>'29.00','order_id'=>'468','set_meal_id'=>'3','member_id'=>'11296']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'189','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 21:06:33','update_time'=>'2022-06-08 21:06:33','title'=>'【单价108】2小时12人间套餐','duration'=>NULL,'price'=>'196.00','renew_price'=>'54.00','order_id'=>'470','set_meal_id'=>'7','member_id'=>'4949']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'190','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-08 22:01:09','update_time'=>'2022-06-08 22:01:09','title'=>'【单价58】2小时4人间套餐','duration'=>NULL,'price'=>'96.00','renew_price'=>'29.00','order_id'=>'472','set_meal_id'=>'3','member_id'=>'11296']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'191','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 11:07:40','update_time'=>'2022-06-09 11:07:40','title'=>'【单价108】2小时12人间套餐','duration'=>NULL,'price'=>'196.00','renew_price'=>'54.00','order_id'=>'476','set_meal_id'=>'7','member_id'=>'11301']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'192','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-09 23:21:56','update_time'=>'2022-06-09 23:21:56','title'=>'【单价88】2小时6人间套餐','duration'=>NULL,'price'=>'156.00','renew_price'=>'44.00','order_id'=>'481','set_meal_id'=>'6','member_id'=>'4949']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'193','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-10 19:21:50','update_time'=>'2022-06-10 19:21:50','title'=>'【单价108】2小时12人间套餐','duration'=>NULL,'price'=>'196.00','renew_price'=>'54.00','order_id'=>'482','set_meal_id'=>'7','member_id'=>'4949']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'194','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-10 19:25:13','update_time'=>'2022-06-10 19:25:13','title'=>'【单价88】2小时6人间套餐','duration'=>NULL,'price'=>'156.00','renew_price'=>'44.00','order_id'=>'483','set_meal_id'=>'6','member_id'=>'4949']);
        $this->insert('{{%diandi_tea_set_meal_list}}',['id'=>'195','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-06-10 19:26:52','update_time'=>'2022-06-10 19:26:52','title'=>'【单价68】2小时4人间套餐','duration'=>NULL,'price'=>'116.00','renew_price'=>'34.00','order_id'=>'484','set_meal_id'=>'13','member_id'=>'4949']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_set_meal_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

