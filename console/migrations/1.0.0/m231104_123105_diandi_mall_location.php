<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_location extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_location}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'name' => "varchar(50) NULL DEFAULT '' COMMENT '位置名称'",
            'maxnum' => "int(11) NULL COMMENT '显示数量'",
            'mark' => "varchar(255) NULL DEFAULT '' COMMENT '英文标记'",
            'is_show' => "int(10) NULL COMMENT '是否显示'",
            'page' => "varchar(255) NULL COMMENT '页面'",
            'type' => "int(11) NULL COMMENT '广告位类型'",
            'style' => "int(11) NULL COMMENT '排列样式'",
            'thumb' => "varchar(255) NULL",
            'is_show_thumb' => "int(11) unsigned NULL DEFAULT '0'",
            'goods_id' => "int(11) NULL",
            'url' => "varchar(255) NULL",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('indx_weid','{{%diandi_mall_location}}','bloc_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_location}}',['id'=>'1','store_id'=>'62','bloc_id'=>'13','name'=>'智能设备','maxnum'=>'1','mark'=>'bj','is_show'=>'1','page'=>'0','type'=>'1','style'=>'3','thumb'=>'202207/28/18b2b698-0b42-3c5e-971f-b547f8180138.png','is_show_thumb'=>'1','goods_id'=>'1','url'=>'index','displayorder'=>'1']);
        $this->insert('{{%diandi_mall_location}}',['id'=>'15','store_id'=>'62','bloc_id'=>'13','name'=>'店滴云授权','maxnum'=>'3','mark'=>'authorization','is_show'=>'1','page'=>'0','type'=>'1','style'=>'2','thumb'=>'202207/28/68221bed-f0a2-3d4e-a8df-105dcca91796.png','is_show_thumb'=>'1','goods_id'=>'5','url'=>'1','displayorder'=>'1']);
        $this->insert('{{%diandi_mall_location}}',['id'=>'16','store_id'=>'62','bloc_id'=>'13','name'=>'官方产品','maxnum'=>'5','mark'=>'product','is_show'=>'1','page'=>'0','type'=>'1','style'=>'4','thumb'=>'202207/28/c2cfa2eb-8ce1-3951-bebf-ad7891898400.png','is_show_thumb'=>'1','goods_id'=>'0','url'=>NULL,'displayorder'=>'3']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_location}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

