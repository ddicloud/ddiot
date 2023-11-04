<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_gift extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_gift}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'performance' => "decimal(11,2) NULL COMMENT '业绩'",
            'gift_price' => "decimal(10,2) NULL COMMENT '礼包价格'",
            'thumb' => "varchar(255) NULL COMMENT '礼包主图'",
            'salers' => "int(11) NULL COMMENT '销量'",
            'images' => "text NULL COMMENT '礼包相册'",
            'old_goods_type' => "int(11) NULL COMMENT '商品类型'",
            'level_num' => "int(11) NULL COMMENT '礼包对应的会员等级'",
            'content' => "text NULL COMMENT '礼包介绍'",
            'cate' => "int(11) NULL",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='礼包'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_hub_gift}}','goods_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_gift}}',['id'=>'1','bloc_id'=>'8','store_id'=>'65','goods_id'=>'1','performance'=>'34.00','gift_price'=>'23.00','thumb'=>'202107/17/4cbf95ea-b588-3b6d-80a5-e0f28fec8625.png','salers'=>NULL,'images'=>'a:1:{i:0;s:50:"202107/17/ce4681bd-fb63-3239-9007-9af48b147809.png";}','old_goods_type'=>NULL,'level_num'=>'1','content'=>'<p>热天热帖热特让他</p>','cate'=>'0','create_time'=>'1626530984','update_time'=>'1626530984']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_gift}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

