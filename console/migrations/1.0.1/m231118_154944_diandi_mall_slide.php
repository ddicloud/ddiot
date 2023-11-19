<?php

use yii\db\Migration;

class m231118_154944_diandi_mall_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_slide}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'thumb' => "varchar(255) NULL COMMENT '图片'",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'title' => "varchar(255) NULL COMMENT '名称'",
            'terminal_type' => "int(11) NULL",
            'goods_id' => "int(11) NULL",
            'url' => "varchar(255) NULL",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'update_time' => "int(11) NULL",
            'create_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='抽奖幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_slide}}',['id'=>'1','thumb'=>'202207/22/9f4d398f-194a-3975-b44a-212670144c49.png','store_id'=>'62','bloc_id'=>'13','title'=>'1','terminal_type'=>'0','goods_id'=>NULL,'url'=>'index','displayorder'=>'1','update_time'=>'1658455061','create_time'=>'1657708993']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

