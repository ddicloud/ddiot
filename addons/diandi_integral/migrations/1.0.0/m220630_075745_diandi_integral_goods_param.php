<?php

use yii\db\Migration;

class m220630_075745_diandi_integral_goods_param extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_goods_param}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司id'",
            'store_id' => "int(11) NULL COMMENT '商户id'",
            'goods_id' => "int(10) NULL DEFAULT '0' COMMENT '商品id'",
            'title' => "varchar(50) NULL DEFAULT '' COMMENT '属性名称'",
            'value' => "varchar(50) NULL COMMENT '属性值'",
            'displayorder' => "int(11) NULL DEFAULT '0' COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'23','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'16','title'=>'第一属性89005','value'=>'345','displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'24','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'16','title'=>'第二属性','value'=>'3234354','displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'25','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'16','title'=>'第一属性55','value'=>'345','displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'26','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'16','title'=>'第一属性89','value'=>'345','displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'27','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'28','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'29','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'30','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'31','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'32','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'33','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'34','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'35','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'36','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'37','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'0','title'=>'','value'=>NULL,'displayorder'=>'0']);
        $this->insert('{{%diandi_integral_goods_param}}',['id'=>'38','bloc_id'=>NULL,'store_id'=>NULL,'goods_id'=>'16','title'=>'新的一个额','value'=>'343434343','displayorder'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_goods_param}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

