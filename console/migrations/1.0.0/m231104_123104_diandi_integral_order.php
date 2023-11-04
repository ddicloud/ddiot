<?php

use yii\db\Migration;

class m231104_123104_diandi_integral_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_order}}', [
            'order_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'order_type' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'order_no' => "varchar(20) NOT NULL DEFAULT ''",
            'order_body' => "varchar(255) NULL",
            'pay_integral' => "decimal(11,2) NULL COMMENT '兑换积分'",
            'total_price' => "decimal(10,2) unsigned NOT NULL",
            'pay_price' => "decimal(10,2) unsigned NOT NULL",
            'pay_status' => "tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '0.未付款 1.已付款 2.已退款'",
            'pay_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'express_price' => "decimal(10,2) unsigned NOT NULL",
            'express_company' => "varchar(50) NOT NULL DEFAULT ''",
            'express_no' => "varchar(50) NOT NULL DEFAULT ''",
            'delivery_status' => "tinyint(3) unsigned NOT NULL DEFAULT '0'",
            'delivery_time' => "varchar(20) NOT NULL DEFAULT '0' COMMENT '发货时间'",
            'receipt_status' => "tinyint(3) unsigned NOT NULL DEFAULT '10'",
            'receipt_time' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货时间'",
            'order_status' => "tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '0.未兑换 1.已兑换 2.已发货 3.已收货 4.已完成 10.已取消'",
            'transaction_id' => "varchar(30) NOT NULL DEFAULT ''",
            'user_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'remark' => "varchar(255) NULL",
            'print_id' => "varchar(255) NULL",
            'is_money' => "int(11) NOT NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`order_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('order_no','{{%diandi_integral_order}}','order_no',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'3','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061653985049','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1686910005','update_time'=>'1686910005']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'4','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061697102505','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1686910122','update_time'=>'1686910122']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'5','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061699495555','order_body'=>'商品三','pay_integral'=>NULL,'total_price'=>'44.00','pay_price'=>'44.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1686910236','update_time'=>'1686910236']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'6','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061910148995','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'1','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687136958','update_time'=>'1687136958']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'7','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061997100549','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687137146','update_time'=>'1687137146']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'8','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061952545653','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687137204','update_time'=>'1687137204']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'9','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061951974949','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687137459','update_time'=>'1687137459']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'10','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061998100541','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687137851','update_time'=>'1687137851']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'11','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061951985352','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687138115','update_time'=>'1687138115']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'12','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061910097575','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687138445','update_time'=>'1687138445']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'13','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061998100100','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687138603','update_time'=>'1687138603']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'14','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061957545150','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687139081','update_time'=>'1687139081']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'15','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061997100974','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687139146','update_time'=>'1687139146']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'16','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061910051565','order_body'=>'商品二','pay_integral'=>NULL,'total_price'=>'15.00','pay_price'=>'15.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687140909','update_time'=>'1687140909']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'17','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061955529848','order_body'=>'商品三','pay_integral'=>'122.00','total_price'=>'44.00','pay_price'=>'44.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687141223','update_time'=>'1687141223']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'18','order_type'=>NULL,'bloc_id'=>'38','store_id'=>'138','order_no'=>'2023061910299565','order_body'=>'商品名称','pay_integral'=>'11.00','total_price'=>'1.00','pay_price'=>'1.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'278','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687170015','update_time'=>'1687170015']);
        $this->insert('{{%diandi_integral_order}}',['order_id'=>'19','order_type'=>NULL,'bloc_id'=>'91','store_id'=>'153','order_no'=>'2023062949485599','order_body'=>'商品名称','pay_integral'=>'11.00','total_price'=>'1.00','pay_price'=>'1.00','pay_status'=>'0','pay_time'=>'0','express_price'=>'0.00','express_company'=>'','express_no'=>'','delivery_status'=>'0','delivery_time'=>'0','receipt_status'=>'10','receipt_time'=>'0','order_status'=>'0','transaction_id'=>'','user_id'=>'1','wxapp_id'=>'0','remark'=>'','print_id'=>NULL,'is_money'=>'0','create_time'=>'1687996529','update_time'=>'1687996529']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

