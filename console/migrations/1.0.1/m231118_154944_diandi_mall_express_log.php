<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_express_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_express_log}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'Action' => "varchar(255) NULL COMMENT '步骤编号'",
            'ShipperCode' => "varchar(255) NULL COMMENT '编码'",
            'LogisticCode' => "varchar(255) NULL",
            'Location' => "varchar(30) NULL DEFAULT '0' COMMENT '所在地'",
            'AcceptStation' => "varchar(255) NULL COMMENT '处理详情'",
            'AcceptTime' => "int(11) NULL COMMENT '处理时间'",
            'Remark' => "varchar(30) NULL COMMENT '状态备注'",
            'EstimatedDeliveryTime' => "varchar(30) NULL COMMENT '签收时间'",
            'State' => "int(11) NULL COMMENT '快递状态'",
            'EBusinessID' => "int(11) NULL COMMENT '用户id'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_express_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

