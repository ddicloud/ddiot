<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_goods}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'goods_name' => "varchar(100) NULL COMMENT '商品名称'",
            'share_title' => "varchar(100) NULL COMMENT '分销标题'",
            'share_desc' => "varchar(100) NULL DEFAULT '1' COMMENT '分销描述'",
            'share_img' => "varchar(100) NULL COMMENT '分销描述'",
            'one_options' => "decimal(11,2) NULL",
            'two_options' => "decimal(11,2) NULL",
            'three_options' => "decimal(11,2) NULL",
            'type' => "smallint(6) NULL COMMENT '分销类型'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_hub_goods}}','goods_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_goods}}',['id'=>'12','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'标题','share_desc'=>'描述','share_img'=>'202202/26/6fa47681-2d54-3e23-b607-5e0e72cb4db8.jpg','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'13','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'1·','share_desc'=>'·1','share_img'=>'202202/26/a0f91e25-b63a-319a-a12a-898ed58314b0.jpg','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'14','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'测试','share_desc'=>'测试','share_img'=>'202202/26/042207b4-0f8f-31fe-b1f3-3c927e9c69a1.jpg','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'15','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'分销标题','share_desc'=>'描述','share_img'=>'202202/26/5a2527a8-95d3-3672-b50d-e2e7c72e0498.png','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'16','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'我','share_desc'=>'我','share_img'=>'202202/26/0f35a6fe-1926-39d6-9b12-751a41af05e6.jpg','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'17','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'测试数据完整性','share_desc'=>'描述','share_img'=>'202202/26/83e8388b-7c16-33c3-9116-fbc3b0d280d0.png','one_options'=>NULL,'two_options'=>NULL,'three_options'=>NULL,'type'=>'1','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods}}',['id'=>'18','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','goods_name'=>NULL,'share_title'=>'测试完整','share_desc'=>'测试描述1','share_img'=>'202202/26/2e1ce9c0-9822-3ba7-8933-80b141d4ecf5.png','one_options'=>'77.00','two_options'=>'66.00','three_options'=>'3.00','type'=>'2','create_time'=>'1645842385','update_time'=>'1645842385']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

