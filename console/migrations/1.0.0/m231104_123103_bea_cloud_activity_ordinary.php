<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_ordinary extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_ordinary}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(255) NULL COMMENT '活动名称'",
            'desc' => "text NULL COMMENT '活动介绍'",
            'product_id' => "int(11) NULL COMMENT '产品ID'",
            'view_count' => "int(11) NULL DEFAULT '0' COMMENT '浏览次数'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'activity_price' => "decimal(10,2) NULL COMMENT '活动价格'",
            'old_price' => "decimal(10,2) NULL COMMENT '原价'",
            'start_time' => "datetime NULL COMMENT '开始时间'",
            'end_time' => "datetime NULL COMMENT '结束时间'",
            'is_cash_audit' => "tinyint(4) NULL COMMENT '是否核销后分佣'",
            'is_mark' => "tinyint(4) NULL COMMENT '是否备注'",
            'music' => "text NULL",
            'is_music' => "tinyint(4) NULL COMMENT '是否开启音乐'",
            'stock' => "int(11) NULL COMMENT '库存'",
            'sale_limit' => "int(11) NULL COMMENT '每人限购数量'",
            'thumb' => "varchar(255) NULL COMMENT '活动主图'",
            'index_thumb' => "varchar(255) NULL COMMENT '活动首页列表图'",
            'share_thumb' => "varchar(255) NULL COMMENT '分享图片'",
            'title_color' => "varchar(50) NULL COMMENT '标题颜色'",
            'bg_color' => "varchar(50) NULL COMMENT '背景颜色'",
            'btn_color' => "varchar(50) NULL COMMENT '按钮颜色'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='拼团活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_ordinary}}',['id'=>'2','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 09:53:03','update_time'=>'2023-03-15 22:15:04','title'=>'1店常规活动','desc'=>'<p>商品介绍</p><p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230315/1678845178104688.jpg\" title=\"1678845178104688.jpg\" alt=\"d154033aa434f0fe.jpg\"/></p>','product_id'=>'22','view_count'=>'18','displayorder'=>'1','activity_price'=>'12.00','old_price'=>'78.00','start_time'=>'2023-03-01 00:00:00','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'0','is_mark'=>'1','music'=>'a:1:{i:0;a:5:{s:4:"name";s:31:"7240_李玲玉-六月茉莉.mp3";s:10:"attachment";s:41:"202303/15/7240_李玲玉-六月茉莉.mp3";s:3:"url";s:74:"https://bea.ddicms.cn/attachment/202303/15/7240_李玲玉-六月茉莉.mp3";s:4:"size";s:7:"1186044";s:3:"uid";s:13:"1678877936348";}}','is_music'=>'1','stock'=>'6','sale_limit'=>'1','thumb'=>'202303/15/79b143f1-ff56-3a71-91de-9cb31579788c.jpg','index_thumb'=>'a:2:{i:0;s:50:"202303/15/4ad31d90-d079-3225-9304-d61fdb8d14f3.jpg";i:1;s:50:"202303/15/bc9c362f-658a-32a3-8b6a-c9ac6640df50.jpg";}','share_thumb'=>'202303/15/216735bf-b1ec-30e1-8f54-45d3eda96aa7.jpg','title_color'=>'#EE0D0D','bg_color'=>'#9A8888','btn_color'=>'#00FF37']);
        $this->insert('{{%bea_cloud_activity_ordinary}}',['id'=>'4','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 16:15:40','update_time'=>'2023-03-15 22:21:50','title'=>'测试音乐','desc'=>'<p>2323</p>','product_id'=>'22','view_count'=>'184','displayorder'=>'1','activity_price'=>'12.00','old_price'=>'1.00','start_time'=>'2023-03-15 16:15:08','end_time'=>'2023-03-24 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:6:{s:4:"name";s:31:"9099_李玲玉-六月茉莉.mp3";s:10:"attachment";s:41:"202303/15/9099_李玲玉-六月茉莉.mp3";s:3:"url";s:74:"https://bea.ddicms.cn/attachment/202303/15/9099_李玲玉-六月茉莉.mp3";s:4:"size";s:7:"1186044";s:3:"uid";s:13:"1678878550550";s:6:"status";s:7:"success";}}','is_music'=>'1','stock'=>'0','sale_limit'=>'2','thumb'=>'202303/15/9f22321d-4f29-3c3e-a34b-7506f31385e8.jpg','index_thumb'=>'a:1:{i:0;s:50:"202303/15/39ff6762-0baf-3e74-834b-9f0f13825f35.jpg";}','share_thumb'=>'202303/15/d483a855-faa4-3ec7-b336-794b765f3e4d.jpg','title_color'=>'','bg_color'=>'','btn_color'=>'']);
        $this->insert('{{%bea_cloud_activity_ordinary}}',['id'=>'6','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-20 11:03:38','update_time'=>'2023-03-23 19:15:55','title'=>'袋袋水常规活动','desc'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230320/1679281308450586.jpg\" title=\"1679281308450586.jpg\" alt=\"7d2f37eb49cc55c1.jpg\"/></p><p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230320/1679281319749866.jpg\" title=\"1679281319749866.jpg\" alt=\"5ab07bb5895b4091.jpg\"/></p>','product_id'=>'26','view_count'=>'398','displayorder'=>NULL,'activity_price'=>'25.00','old_price'=>'30.00','start_time'=>'2023-03-20 00:00:00','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:6:{s:4:"name";s:50:"4999_邓寓君(等什么君)-孤勇者(片段).mp3";s:10:"attachment";s:60:"202303/20/4999_邓寓君(等什么君)-孤勇者(片段).mp3";s:3:"url";s:93:"https://bea.ddicms.cn/attachment/202303/20/4999_邓寓君(等什么君)-孤勇者(片段).mp3";s:4:"size";s:7:"1110800";s:3:"uid";s:13:"1679300695664";s:6:"status";s:7:"success";}}','is_music'=>'1','stock'=>'56','sale_limit'=>'50','thumb'=>'202303/20/dcf20024-c881-3259-a5ac-e102d2f1ed46.jpg','index_thumb'=>'a:2:{i:0;s:50:"202303/20/0750d3d1-b65e-36e8-8765-42c54618efc1.jpg";i:1;s:50:"202303/20/04fdd1fd-4dbb-31ef-b2ec-5fa27e135846.jpg";}','share_thumb'=>'202303/20/8843eec2-c03f-33ac-8329-b39f1a53482a.jpg','title_color'=>'','bg_color'=>'','btn_color'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_ordinary}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

