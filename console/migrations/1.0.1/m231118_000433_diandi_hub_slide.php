<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_slide extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_slide}}', [
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
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='抽奖幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_slide}}',['id'=>'1','thumb'=>'202203/09/84c97b3e-cb4d-3af5-bb6a-72700427be1f.jpg','store_id'=>'78','bloc_id'=>'29','title'=>'1','terminal_type'=>'0','goods_id'=>'0','url'=>'1','displayorder'=>'1','update_time'=>'1646811954','create_time'=>'1646811954']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_slide}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

