<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_basegoods_label extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_basegoods_label}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'label' => "varchar(4) NULL COMMENT '商品标签'",
            'thumb' => "varchar(255) NULL COMMENT '标签图片'",
            'color' => "varchar(10) NULL COMMENT '标签颜色'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('store_id','{{%diandi_mall_basegoods_label}}','store_id, bloc_id, label',1);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_basegoods_label}}',['id'=>'1','store_id'=>'62','bloc_id'=>'13','label'=>'1','thumb'=>'202207/13/11a05716-475e-36a7-a953-1a5ab8a40bc2.jpg','color'=>'#409EFF']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_basegoods_label}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

