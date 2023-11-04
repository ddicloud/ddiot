<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_seckill extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_seckill}}', [
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
            'activity_price' => "decimal(10,2) NULL DEFAULT '0.00' COMMENT '活动价格'",
            'old_price' => "decimal(10,2) NULL DEFAULT '0.00' COMMENT '原价'",
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
            'btn_color' => "varchar(50) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='拼团活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_seckill}}',['id'=>'1','store_id'=>'152','bloc_id'=>'51','create_time'=>'2023-02-18 16:18:18','update_time'=>'2023-03-15 11:48:58','title'=>'限时描述活动名称','desc'=>'','product_id'=>NULL,'view_count'=>'330','displayorder'=>'1','activity_price'=>'22.12','old_price'=>'900.00','start_time'=>'1970-01-01 08:32:50','end_time'=>'1970-01-01 08:32:50','is_cash_audit'=>'1','is_mark'=>'1','music'=>NULL,'is_music'=>'1','stock'=>'2','sale_limit'=>'4','thumb'=>'202303/06/6e5d3d95-d1ba-365c-88bd-f79fb4d64b9b.png','index_thumb'=>'a:1:{i:0;s:50:"202303/15/953774b1-f3d4-3e4e-a9da-38453cde4e6c.jpg";}','share_thumb'=>'202303/06/f854cf64-e538-3eca-9c80-c7cc71bc99cf.png','title_color'=>'12','bg_color'=>'3','btn_color'=>NULL]);
        $this->insert('{{%bea_cloud_activity_seckill}}',['id'=>'7','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-15 11:33:59','update_time'=>'2023-03-15 22:14:46','title'=>'活动名称','desc'=>'<p>介绍</p>','product_id'=>'24','view_count'=>'0','displayorder'=>'1','activity_price'=>'12.00','old_price'=>NULL,'start_time'=>'2023-03-15 19:56:02','end_time'=>'2023-03-30 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:6:{s:4:"name";s:31:"6106_李玲玉-六月茉莉.mp3";s:10:"attachment";s:41:"202303/15/6106_李玲玉-六月茉莉.mp3";s:3:"url";s:74:"https://bea.ddicms.cn/attachment/202303/15/6106_李玲玉-六月茉莉.mp3";s:4:"size";s:7:"1186044";s:3:"uid";s:13:"1678881371282";s:6:"status";s:7:"success";}}','is_music'=>'1','stock'=>'1','sale_limit'=>'2','thumb'=>'202303/15/5f80fd75-c9e2-37f8-94be-5253911ad108.png','index_thumb'=>'a:1:{i:0;s:50:"202303/15/f8ea6f02-7b20-3c43-b4be-2d247ddc0ef0.png";}','share_thumb'=>'202303/15/1ccaddb4-7771-3646-87f4-d183979e4cdf.png','title_color'=>'#DE0808','bg_color'=>'#3300FF','btn_color'=>'#A2FF00']);
        $this->insert('{{%bea_cloud_activity_seckill}}',['id'=>'8','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 20:37:05','update_time'=>'2023-03-15 20:38:17','title'=>'测试门店错误','desc'=>'<p>活动详情</p>','product_id'=>'22','view_count'=>'4','displayorder'=>'1','activity_price'=>NULL,'old_price'=>NULL,'start_time'=>'2023-03-15 20:36:31','end_time'=>'2023-03-24 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:5:{s:4:"name";s:31:"7129_李玲玉-六月茉莉.mp3";s:10:"attachment";s:41:"202303/15/7129_李玲玉-六月茉莉.mp3";s:3:"url";s:74:"https://bea.ddicms.cn/attachment/202303/15/7129_李玲玉-六月茉莉.mp3";s:4:"size";s:7:"1186044";s:3:"uid";s:13:"1678883799860";}}','is_music'=>'1','stock'=>'0','sale_limit'=>'2','thumb'=>'202303/15/8b73498a-1feb-3673-ab71-29d1a3cbead5.png','index_thumb'=>'a:1:{i:0;s:50:"202303/15/411ed098-3aae-3a91-92e4-be93d208c02b.png";}','share_thumb'=>'202303/15/4413a15d-caf5-3121-ab34-c1487abc5936.png','title_color'=>'','bg_color'=>'','btn_color'=>NULL]);
        $this->insert('{{%bea_cloud_activity_seckill}}',['id'=>'9','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:46:53','update_time'=>'2023-03-23 21:58:30','title'=>'山泉水秒杀活动','desc'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230323/1679575494500685.jpg\" title=\"1679575494500685.jpg\" alt=\"7d2f37eb49cc55c1.jpg\"/></p><p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230323/1679575504164474.jpg\" title=\"1679575504164474.jpg\" alt=\"5ab07bb5895b4091.jpg\"/></p>','product_id'=>'26','view_count'=>'12','displayorder'=>NULL,'activity_price'=>'0.50','old_price'=>NULL,'start_time'=>'2023-03-23 20:44:05','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:5:{s:4:"name";s:50:"5659_邓寓君(等什么君)-孤勇者(片段).mp3";s:10:"attachment";s:60:"202303/23/5659_邓寓君(等什么君)-孤勇者(片段).mp3";s:3:"url";s:93:"https://bea.ddicms.cn/attachment/202303/23/5659_邓寓君(等什么君)-孤勇者(片段).mp3";s:4:"size";s:7:"1110800";s:3:"uid";s:13:"1679575471321";}}','is_music'=>'1','stock'=>'90','sale_limit'=>'10','thumb'=>'202303/23/1fa963eb-a255-3e4a-ba09-3e175c8b8be7.jpg','index_thumb'=>'a:2:{i:0;s:50:"202303/23/e955b85c-b68b-377c-a4e0-1fb129ac031e.jpg";i:1;s:50:"202303/23/06fedace-cff9-34ac-b9b9-b54141b4ec58.jpg";}','share_thumb'=>'202303/23/4d4ba470-8c69-3fcd-a712-42e626967ebb.jpg','title_color'=>'','bg_color'=>'','btn_color'=>'']);
        $this->insert('{{%bea_cloud_activity_seckill}}',['id'=>'11','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 20:52:30','update_time'=>'2023-03-23 20:52:30','title'=>'测试rule','desc'=>'<p>1221</p>','product_id'=>'26','view_count'=>'0','displayorder'=>'1','activity_price'=>NULL,'old_price'=>NULL,'start_time'=>'2023-03-23 20:52:09','end_time'=>'2023-03-30 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'N;','is_music'=>'1','stock'=>'1','sale_limit'=>'2','thumb'=>NULL,'index_thumb'=>'a:0:{}','share_thumb'=>NULL,'title_color'=>NULL,'bg_color'=>NULL,'btn_color'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_seckill}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

