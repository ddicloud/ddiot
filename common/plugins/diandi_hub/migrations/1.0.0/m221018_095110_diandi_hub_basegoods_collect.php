<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_basegoods_collect extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_basegoods_collect}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'goods_type' => "int(11) NULL",
            'goods_id' => "int(1) NULL COMMENT '商品id'",
            'member_id' => "int(11) NULL COMMENT '用户id'",
            'create_time' => "int(11) NULL COMMENT '收藏时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_basegoods_collect}}',['id'=>'7','bloc_id'=>'33','store_id'=>'82','goods_type'=>'2','goods_id'=>'4','member_id'=>'58','create_time'=>'1650799816','update_time'=>'1650799816']);
        $this->insert('{{%diandi_hub_basegoods_collect}}',['id'=>'9','bloc_id'=>'33','store_id'=>'82','goods_type'=>'1','goods_id'=>'4','member_id'=>'4946','create_time'=>'1650850126','update_time'=>'1650850126']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_basegoods_collect}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

