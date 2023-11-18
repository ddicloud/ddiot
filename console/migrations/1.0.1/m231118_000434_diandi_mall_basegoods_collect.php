<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_basegoods_collect extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_basegoods_collect}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'goods_type' => "int(11) NULL",
            'goods_id' => "int(1) NULL COMMENT '商品id'",
            'member_id' => "int(11) NULL COMMENT '用户id'",
            'create_time' => "int(11) NULL COMMENT '收藏时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_basegoods_collect}}',['id'=>'3','bloc_id'=>'13','store_id'=>'62','goods_type'=>'2','goods_id'=>'5','member_id'=>'2','create_time'=>'1658388227','update_time'=>'1658388227']);
        $this->insert('{{%diandi_mall_basegoods_collect}}',['id'=>'4','bloc_id'=>'13','store_id'=>'62','goods_type'=>'2','goods_id'=>'10','member_id'=>'2','create_time'=>'1658390434','update_time'=>'1658390434']);
        $this->insert('{{%diandi_mall_basegoods_collect}}',['id'=>'5','bloc_id'=>'13','store_id'=>'62','goods_type'=>'2','goods_id'=>'1','member_id'=>'8','create_time'=>'1658894175','update_time'=>'1658894175']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_basegoods_collect}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

