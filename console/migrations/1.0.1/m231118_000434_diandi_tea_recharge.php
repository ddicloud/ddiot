<?php

use yii\db\Migration;

class m231118_000434_diandi_tea_recharge extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_recharge}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '充值活动列表id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'price' => "decimal(10,2) NULL COMMENT '价格'",
            'give_money' => "decimal(10,2) NULL COMMENT '赠送金额'",
            'give_coupon_ids' => "varchar(100) NULL COMMENT '赠送卡券id集合'",
            'type' => "smallint(2) NULL COMMENT '是否为活动套餐：1.是 2否'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='充值套餐表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_recharge}}',['id'=>'4','bloc_id'=>'91','store_id'=>'153','create_time'=>'0000-00-00 00:00:00','update_time'=>'2022-06-09 18:28:01','price'=>'300.00','give_money'=>'30.00','give_coupon_ids'=>'7','type'=>'1']);
        $this->insert('{{%diandi_tea_recharge}}',['id'=>'5','bloc_id'=>'91','store_id'=>'153','create_time'=>'0000-00-00 00:00:00','update_time'=>'2022-06-09 18:16:07','price'=>'3000.00','give_money'=>'1000.00','give_coupon_ids'=>'7','type'=>'1']);
        $this->insert('{{%diandi_tea_recharge}}',['id'=>'7','bloc_id'=>'91','store_id'=>'153','create_time'=>'0000-00-00 00:00:00','update_time'=>'2022-06-09 18:16:18','price'=>'1000.00','give_money'=>'200.00','give_coupon_ids'=>'7','type'=>'1']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_recharge}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

