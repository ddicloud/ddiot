<?php

use yii\db\Migration;

class m221018_095111_diandi_hub_money_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_money_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'order_id' => "int(11) NULL COMMENT '订单ID'",
            'levelnum' => "int(11) NULL COMMENT '会员等级'",
            'member_id' => "int(11) NULL COMMENT '会员id'",
            'order_money' => "decimal(11,2) NULL COMMENT '分销金额参数'",
            'money' => "decimal(11,2) NULL COMMENT '分销金额'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_money_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

