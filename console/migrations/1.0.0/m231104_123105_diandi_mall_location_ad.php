<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_location_ad extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_location_ad}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'thumb' => "varchar(255) NULL COMMENT '图片'",
            'location_id' => "int(11) NULL COMMENT '广告位id'",
            'mark' => "varchar(255) NULL DEFAULT '' COMMENT '英文标记'",
            'is_show' => "int(10) NULL COMMENT '是否显示'",
            'name' => "varchar(255) NULL",
            'goods_id' => "int(11) NULL",
            'url' => "varchar(255) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('indx_weid','{{%diandi_mall_location_ad}}','bloc_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_location_ad}}',['id'=>'1','store_id'=>'62','bloc_id'=>'13','thumb'=>'202207/14/c51a66f2-ba5d-3dd2-85d1-f1c374541c8c.png','location_id'=>'2','mark'=>NULL,'is_show'=>'1','name'=>'','goods_id'=>'2','url'=>'indextop']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_location_ad}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

