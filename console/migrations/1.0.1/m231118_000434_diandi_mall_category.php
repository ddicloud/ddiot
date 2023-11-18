<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_category}}', [
            'category_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称'",
            'parent_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'image_id' => "varchar(250) NOT NULL",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'goods_id' => "int(11) NULL",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`category_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类管理'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'1','store_id'=>'62','bloc_id'=>'13','name'=>'智能门锁','parent_id'=>'0','image_id'=>'202207/19/a6fb5fcf-8099-3aa1-8b11-5bc9bf8e42e1.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1657692493','update_time'=>'1658222670']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'2','store_id'=>'62','bloc_id'=>'13','name'=>'智能门锁','parent_id'=>'1','image_id'=>'202207/14/45322014-e7dd-390b-b163-f3dbb1946973.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1657692505','update_time'=>'1657793964']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'3','store_id'=>'62','bloc_id'=>'13','name'=>'分类二二','parent_id'=>'0','image_id'=>'202207/19/de9e9e1c-642b-38f6-a0f6-2d025d9ce303.jpg','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658222565','update_time'=>'1658222565']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'4','store_id'=>'62','bloc_id'=>'13','name'=>'智能开关','parent_id'=>'1','image_id'=>'202207/19/0d3f7a7d-8b02-352d-808a-7bae310eaefd.png','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658224441','update_time'=>'1658224441']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'5','store_id'=>'62','bloc_id'=>'13','name'=>'智能开关','parent_id'=>'1','image_id'=>'202207/19/0be49f23-c19c-3234-a172-f15d58879bb7.png','sort'=>'3','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658224484','update_time'=>'1658224484']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'6','store_id'=>'61','bloc_id'=>'8','name'=>'服务','parent_id'=>'0','image_id'=>'202210/09/85933f3d-be44-327c-8621-e28e1c54d179.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1665281170','update_time'=>'1665281170']);
        $this->insert('{{%diandi_mall_category}}',['category_id'=>'7','store_id'=>'61','bloc_id'=>'8','name'=>'服务二级','parent_id'=>'6','image_id'=>'202210/09/a62f0231-bbc1-378f-8179-8375aebaef17.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1665281356','update_time'=>'1665281356']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

