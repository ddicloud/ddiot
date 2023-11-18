<?php

use yii\db\Migration;

class m231118_000433_diandi_hub_location_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_location_goods}}', [
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
        $this->createIndex('indx_weid','{{%diandi_hub_location_goods}}','bloc_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'1','store_id'=>'61','bloc_id'=>'8','goods_id'=>'0','location_id'=>'1','mark'=>'','is_show'=>NULL,'displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'2','store_id'=>'61','bloc_id'=>'8','goods_id'=>'0','location_id'=>'1','mark'=>'','is_show'=>NULL,'displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'18','store_id'=>'82','bloc_id'=>'33','goods_id'=>'4','location_id'=>'9','mark'=>'top','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'26','store_id'=>'80','bloc_id'=>'31','goods_id'=>'31','location_id'=>'14','mark'=>'cnxh','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'27','store_id'=>'80','bloc_id'=>'31','goods_id'=>'26','location_id'=>'14','mark'=>'cnxh','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'34','store_id'=>'80','bloc_id'=>'31','goods_id'=>'32','location_id'=>'15','mark'=>NULL,'is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'29','store_id'=>'80','bloc_id'=>'31','goods_id'=>'23','location_id'=>'14','mark'=>'cnxh','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'24','store_id'=>'80','bloc_id'=>'31','goods_id'=>'33','location_id'=>'14','mark'=>'cnxh','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'25','store_id'=>'80','bloc_id'=>'31','goods_id'=>'24','location_id'=>'14','mark'=>'cnxh','is_show'=>'0','displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location_goods}}',['id'=>'36','store_id'=>'80','bloc_id'=>'31','goods_id'=>'35','location_id'=>'15','mark'=>'cx','is_show'=>'0','displayorder'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_location_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

