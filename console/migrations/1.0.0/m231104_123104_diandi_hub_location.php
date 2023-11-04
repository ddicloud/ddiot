<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_location extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_location}}', [
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
            'goods_id' => "int(11) NULL",
            'url' => "varchar(255) NULL",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('indx_weid','{{%diandi_hub_location}}','bloc_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_location}}',['id'=>'5','store_id'=>'61','bloc_id'=>'8','name'=>'12','maxnum'=>'1','mark'=>'d','is_show'=>'1','page'=>'1','type'=>'1','style'=>'2','thumb'=>'202202/23/4a694a89-743c-3322-83d1-4507e0a331f8.jpg','goods_id'=>'12','url'=>NULL,'displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'6','store_id'=>'75','bloc_id'=>'27','name'=>'1','maxnum'=>'1','mark'=>'','is_show'=>'0','page'=>NULL,'type'=>'1','style'=>'1','thumb'=>NULL,'goods_id'=>NULL,'url'=>NULL,'displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'8','store_id'=>'78','bloc_id'=>'29','name'=>'2','maxnum'=>'1','mark'=>'fas','is_show'=>'1','page'=>'0','type'=>'1','style'=>'2','thumb'=>'202203/09/3ba2d287-e793-3bfb-8501-9343dff95656.jpg','goods_id'=>'0','url'=>'121','displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'9','store_id'=>'82','bloc_id'=>'33','name'=>'头部','maxnum'=>'2','mark'=>'top','is_show'=>'0','page'=>'0','type'=>'1','style'=>'2','thumb'=>'202204/24/8b1caa93-5882-3561-abd0-3f67fef8a574.png','goods_id'=>'4','url'=>'http://localhost:9527/pro-admin/#/diandi_hub/goods/location/create','displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'11','store_id'=>'82','bloc_id'=>'33','name'=>'底部','maxnum'=>'2','mark'=>'type','is_show'=>'0','page'=>'0','type'=>'1','style'=>'2','thumb'=>NULL,'goods_id'=>'4','url'=>'index','displayorder'=>'2']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'12','store_id'=>'82','bloc_id'=>'33','name'=>'中间','maxnum'=>'2','mark'=>'bame','is_show'=>'0','page'=>'0','type'=>'2','style'=>'2','thumb'=>NULL,'goods_id'=>'4','url'=>'index','displayorder'=>'2']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'13','store_id'=>'82','bloc_id'=>'33','name'=>'index','maxnum'=>'1','mark'=>'indexpop','is_show'=>'0','page'=>'0','type'=>'2','style'=>'1','thumb'=>'202204/27/f969cfd1-076e-3dd4-b822-6297c16bda87.jpg','goods_id'=>'4','url'=>'indexpop','displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'14','store_id'=>'80','bloc_id'=>'31','name'=>'猜你喜欢','maxnum'=>'1','mark'=>'cnxh','is_show'=>'0','page'=>'0','type'=>'1','style'=>'7','thumb'=>'202205/21/ec96ee5f-18d4-302e-a24d-1e1ec108e421.jpg','goods_id'=>'26','url'=>'index','displayorder'=>'1']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'15','store_id'=>'80','bloc_id'=>'31','name'=>'促销.推荐 ','maxnum'=>'1','mark'=>'cx','is_show'=>'0','page'=>'0','type'=>'1','style'=>'8','thumb'=>'202205/21/fbc9f067-2c84-3104-8206-22743eb064a2.jpg','goods_id'=>'31','url'=>'index','displayorder'=>'2']);
        $this->insert('{{%diandi_hub_location}}',['id'=>'17','store_id'=>'80','bloc_id'=>'31','name'=>'','maxnum'=>NULL,'mark'=>'','is_show'=>NULL,'page'=>NULL,'type'=>NULL,'style'=>NULL,'thumb'=>NULL,'goods_id'=>NULL,'url'=>NULL,'displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location}}',['id'=>'18','store_id'=>'80','bloc_id'=>'31','name'=>'','maxnum'=>NULL,'mark'=>'','is_show'=>NULL,'page'=>NULL,'type'=>NULL,'style'=>NULL,'thumb'=>NULL,'goods_id'=>NULL,'url'=>NULL,'displayorder'=>NULL]);
        $this->insert('{{%diandi_hub_location}}',['id'=>'19','store_id'=>'80','bloc_id'=>'31','name'=>'','maxnum'=>NULL,'mark'=>'','is_show'=>NULL,'page'=>NULL,'type'=>NULL,'style'=>NULL,'thumb'=>NULL,'goods_id'=>NULL,'url'=>NULL,'displayorder'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_location}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

