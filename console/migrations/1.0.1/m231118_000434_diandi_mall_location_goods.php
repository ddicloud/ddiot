<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_location_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_location_goods}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'goods_id' => "int(11) NULL COMMENT '商品id'",
            'location_id' => "int(11) NULL COMMENT '广告位id'",
            'mark' => "varchar(255) NULL DEFAULT '' COMMENT '英文标记'",
            'is_show' => "int(10) NULL COMMENT '是否显示'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('indx_weid','{{%diandi_mall_location_goods}}','bloc_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'36','store_id'=>'62','bloc_id'=>'13','goods_id'=>'9','location_id'=>'16','mark'=>'product','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'35','store_id'=>'62','bloc_id'=>'13','goods_id'=>'14','location_id'=>'16','mark'=>'product','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'28','store_id'=>'62','bloc_id'=>'13','goods_id'=>'1','location_id'=>'1','mark'=>'bj','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'14','store_id'=>'62','bloc_id'=>'13','goods_id'=>'11','location_id'=>'7','mark'=>NULL,'is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'13','store_id'=>'62','bloc_id'=>'13','goods_id'=>NULL,'location_id'=>NULL,'mark'=>'','is_show'=>NULL,'displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'18','store_id'=>'62','bloc_id'=>'13','goods_id'=>'11','location_id'=>'9','mark'=>'zbott','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'29','store_id'=>'62','bloc_id'=>'13','goods_id'=>'4','location_id'=>'1','mark'=>'bj','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'34','store_id'=>'62','bloc_id'=>'13','goods_id'=>'13','location_id'=>'15','mark'=>'authorization','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'33','store_id'=>'62','bloc_id'=>'13','goods_id'=>'5','location_id'=>'15','mark'=>'authorization','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_mall_location_goods}}',['id'=>'37','store_id'=>'62','bloc_id'=>'13','goods_id'=>'8','location_id'=>'16','mark'=>'product','is_show'=>'0','displayorder'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_location_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

