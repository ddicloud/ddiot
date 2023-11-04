<?php

use yii\db\Migration;

class m231104_123105_diandi_tea_set_meal_renew_list extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_set_meal_renew_list}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '套餐续费记录id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'order_id' => "int(11) NULL COMMENT '订单id'",
            'set_meal_id' => "int(11) NULL COMMENT '套餐id'",
            'price' => "decimal(10,2) NULL COMMENT '半小时单价'",
            'renew_price' => "decimal(10,2) NULL COMMENT '续费总价'",
            'renew_num' => "int(11) NULL COMMENT '续费单位（几个半小时）'",
            'member_id' => "int(11) NULL COMMENT '续费会员id'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='套餐续费记录表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_set_meal_renew_list}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

