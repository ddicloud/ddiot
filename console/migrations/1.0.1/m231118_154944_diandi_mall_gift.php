<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_gift extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_gift}}', [
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
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='礼包'");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_gift}}','goods_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_gift}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

