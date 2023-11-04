<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_goods_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_goods_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'dis_id' => "int(11) NULL COMMENT '分销活动ID'",
            'level_num' => "smallint(6) NULL COMMENT '会员等级'",
            'team_num' => "smallint(6) NULL COMMENT '团队等级'",
            'dis_option' => "decimal(11,2) NULL COMMENT '分销参数'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_goods_level}}','goods_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_goods_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

