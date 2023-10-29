<?php

use yii\db\Migration;

class m221018_095110_diandi_hub_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_category}}', [
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分类管理'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'1','store_id'=>'65','bloc_id'=>'8','name'=>'fenlei1','parent_id'=>'0','image_id'=>'','sort'=>'1','goods_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1626530690','update_time'=>'1626530690']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'2','store_id'=>'65','bloc_id'=>'8','name'=>'erer','parent_id'=>'1','image_id'=>'','sort'=>'1','goods_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1626530717','update_time'=>'1626530717']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'3','store_id'=>'75','bloc_id'=>'27','name'=>'分类','parent_id'=>'0','image_id'=>'202202/26/99b8836d-4aa0-3b7a-b0b7-0d4f0e804587.jpg','sort'=>'1','goods_id'=>'5','wxapp_id'=>'0','create_time'=>'1645847690','update_time'=>'1645855478']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'4','store_id'=>'75','bloc_id'=>'27','name'=>'名称','parent_id'=>'0','image_id'=>'202202/26/13f13890-a4d6-3270-9d0a-cab77b7a55a2.jpg','sort'=>'0','goods_id'=>'5','wxapp_id'=>'0','create_time'=>'1645847715','update_time'=>'1645855514']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'5','store_id'=>'75','bloc_id'=>'27','name'=>'','parent_id'=>'0','image_id'=>'','sort'=>'0','goods_id'=>'5','wxapp_id'=>'0','create_time'=>'1645855517','update_time'=>'1645855517']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'6','store_id'=>'75','bloc_id'=>'27','name'=>'名称1','parent_id'=>'4','image_id'=>'202202/26/d99c09fa-0b8b-3ed4-9136-dd1373a50acc.jpg','sort'=>'3','goods_id'=>'5','wxapp_id'=>'0','create_time'=>'1645855717','update_time'=>'1645855717']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'7','store_id'=>'0','bloc_id'=>'0','name'=>'鹿产品','parent_id'=>'0','image_id'=>'202205/12/4b61cb44-ea51-3b9a-bfd7-7e04932b184b.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1652331018','update_time'=>'1652331108']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'8','store_id'=>'0','bloc_id'=>'0','name'=>'养生酒','parent_id'=>'7','image_id'=>'202205/12/af594187-ebc3-3af1-802d-ba173838332d.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1652331074','update_time'=>'1652331074']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'9','store_id'=>'0','bloc_id'=>'0','name'=>'顶级分类2','parent_id'=>'0','image_id'=>'202205/16/064bb544-4ac9-3168-b37c-cc0e2f504205.jpeg','sort'=>'1','goods_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652689439','update_time'=>'1652689439']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'10','store_id'=>'80','bloc_id'=>'31','name'=>'单头玫瑰','parent_id'=>'0','image_id'=>'202205/16/064bb544-4ac9-3168-b37c-cc0e2f504205.jpeg','sort'=>'1','goods_id'=>NULL,'wxapp_id'=>'0','create_time'=>'1652689730','update_time'=>'1652690315']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'11','store_id'=>'80','bloc_id'=>'31','name'=>'蓝妖宝蓝','parent_id'=>'10','image_id'=>'202205/16/2a2297b8-c984-3393-93e4-bf0f1f753dab.jpeg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1652690296','update_time'=>'1652690296']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'12','store_id'=>'80','bloc_id'=>'31','name'=>'粉红雪山','parent_id'=>'10','image_id'=>'202205/17/406086fd-f973-33b1-91b0-f4131c73b183.jpeg','sort'=>'13','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1652770285','update_time'=>'1652771684']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'13','store_id'=>'80','bloc_id'=>'31','name'=>'高原红','parent_id'=>'10','image_id'=>'202205/17/57b4684d-d1f2-3be2-a5d4-90883f4c9576.jpeg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1652770300','update_time'=>'1652770300']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'14','store_id'=>'80','bloc_id'=>'31','name'=>'猜你喜欢','parent_id'=>'0','image_id'=>'202205/21/0be67163-94e7-34c7-82bc-44ef49a57f41.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1653098779','update_time'=>'1653098779']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'15','store_id'=>'80','bloc_id'=>'31','name'=>'猜你喜欢二级分类','parent_id'=>'14','image_id'=>'202205/21/5bd2dc31-2c94-373b-97f4-c157744d732c.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1653098881','update_time'=>'1653098881']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'16','store_id'=>'82','bloc_id'=>'33','name'=>'分类1','parent_id'=>'0','image_id'=>'202205/26/275a8d0c-cdc5-3298-94dd-21ce10759b04.jpg','sort'=>'1','goods_id'=>'4','wxapp_id'=>'0','create_time'=>'1653549457','update_time'=>'1653549457']);
        $this->insert('{{%diandi_hub_category}}',['category_id'=>'17','store_id'=>'82','bloc_id'=>'33','name'=>'子分类','parent_id'=>'16','image_id'=>'202205/26/9c26d694-f42e-3f74-a78f-12c1cbc0a118.jpg','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1653549474','update_time'=>'1653549474']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

