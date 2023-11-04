<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_activity_groups extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_activity_groups}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(255) NULL COMMENT '活动名称'",
            'desc' => "text NULL COMMENT '活动介绍'",
            'view_count' => "int(11) NULL DEFAULT '0' COMMENT '浏览次数'",
            'product_id' => "int(11) NULL COMMENT '产品ID'",
            'displayorder' => "int(11) NULL COMMENT '排序'",
            'is_join' => "int(11) NULL DEFAULT '0' COMMENT '是否开启参团'",
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
            'time_limit' => "decimal(11,0) NULL COMMENT '成团时间限制'",
            'is_virtual' => "tinyint(4) NULL COMMENT '是否虚拟成团'",
            'is_award' => "tinyint(4) NULL COMMENT '是否开启成团奖励'",
            'award_money' => "decimal(11,2) NULL COMMENT '每人奖励金额'",
            'ladder1_num' => "int(11) NULL COMMENT '阶梯1人数'",
            'ladder1_price' => "decimal(10,2) NULL COMMENT '阶梯1价格'",
            'ladder2_num' => "decimal(10,2) NULL COMMENT '阶梯2人数'",
            'ladder2_price' => "decimal(10,2) NULL COMMENT '阶梯2价格'",
            'is_groups3' => "int(11) NULL DEFAULT '1' COMMENT '是否启动第三组'",
            'ladder3_num' => "decimal(10,2) NULL COMMENT '阶梯3人数'",
            'btn_color' => "varchar(50) NULL COMMENT '阶梯3价格'",
            'ladder3_price' => "decimal(10,2) NULL COMMENT '阶梯3价格'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='拼团活动'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_activity_groups}}',['id'=>'11','store_id'=>'153','bloc_id'=>'51','create_time'=>'2023-03-15 10:29:24','update_time'=>'2023-03-15 10:29:24','title'=>'美白修复3人团','desc'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230315/1678847096918437.jpg\" title=\"1678847096918437.jpg\" alt=\"e13160b7be8a8b11.jpg\"/></p>','view_count'=>'0','product_id'=>'22','displayorder'=>NULL,'is_join'=>'1','start_time'=>'2023-03-01 00:00:00','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'0','is_mark'=>'1','music'=>NULL,'is_music'=>'0','stock'=>'7','sale_limit'=>'1','thumb'=>'202303/15/cc878c9d-971f-384c-a373-196c1b411529.png','index_thumb'=>'a:2:{i:0;s:50:"202303/15/f785fff8-aaeb-3f8e-981e-5d42c90b1981.png";i:1;s:50:"202303/15/16ad9197-1511-3213-a6ca-fcdeeb8f3906.png";}','share_thumb'=>'202303/15/bf70bcfa-b210-36c1-a432-a1031f0fc51d.png','title_color'=>NULL,'bg_color'=>NULL,'time_limit'=>'2','is_virtual'=>'1','is_award'=>'0','award_money'=>NULL,'ladder1_num'=>'3','ladder1_price'=>'1.00','ladder2_num'=>NULL,'ladder2_price'=>NULL,'is_groups3'=>'1','ladder3_num'=>NULL,'btn_color'=>NULL,'ladder3_price'=>NULL]);
        $this->insert('{{%bea_cloud_activity_groups}}',['id'=>'13','store_id'=>'150','bloc_id'=>'51','create_time'=>'2023-03-23 22:02:29','update_time'=>'2023-03-24 11:12:05','title'=>'3人团袋袋水','desc'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230323/1679579952329029.jpg\" title=\"1679579952329029.jpg\" alt=\"f712b641f405013a.jpg\"/></p>','view_count'=>'79','product_id'=>'26','displayorder'=>NULL,'is_join'=>'1','start_time'=>'2023-03-23 00:00:00','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'N;','is_music'=>'1','stock'=>'99','sale_limit'=>'10','thumb'=>'202303/23/a1955ad2-b709-3255-b9b3-168d2c92f8dc.jpg','index_thumb'=>'a:2:{i:0;s:50:"202303/23/56defb96-f90e-3b32-8488-b9a57a5fa106.jpg";i:1;s:50:"202303/23/6122ba9c-3ea8-37a3-9dfd-a3f0e1b310a1.jpg";}','share_thumb'=>'202303/23/9d1459c9-5af3-34d2-b2be-7909534e68dc.jpg','title_color'=>NULL,'bg_color'=>NULL,'time_limit'=>'1','is_virtual'=>'1','is_award'=>'0','award_money'=>NULL,'ladder1_num'=>'3','ladder1_price'=>'0.50','ladder2_num'=>NULL,'ladder2_price'=>NULL,'is_groups3'=>'0','ladder3_num'=>NULL,'btn_color'=>NULL,'ladder3_price'=>NULL]);
        $this->insert('{{%bea_cloud_activity_groups}}',['id'=>'10','store_id'=>'153','bloc_id'=>'51','create_time'=>'2023-03-15 10:21:43','update_time'=>'2023-03-15 10:21:43','title'=>'4店拼团互动','desc'=>'<p><img src=\"https://bea.ddicms.cn/admin/../attachment/image/20230315/1678846847546095.jpg\" title=\"1678846847546095.jpg\" alt=\"365f3d0ae228ba76.jpg\"/></p>','view_count'=>'0','product_id'=>'23','displayorder'=>'1','is_join'=>'0','start_time'=>'2023-03-01 00:00:00','end_time'=>'2023-03-31 00:00:00','is_cash_audit'=>'0','is_mark'=>'0','music'=>NULL,'is_music'=>'0','stock'=>'8','sale_limit'=>'1','thumb'=>'202303/15/51bebe2d-ac4a-332f-a1cf-5939b871f869.jpg','index_thumb'=>'a:2:{i:0;s:50:"202303/15/a8531fa7-a578-3af8-a922-8d126490d0a5.jpg";i:1;s:50:"202303/15/cbca7711-57d3-3643-9d23-12e72fe7a220.jpg";}','share_thumb'=>'202303/15/24e6a9bf-08d1-3bca-b973-f20422d03c86.png','title_color'=>'#9500FF','bg_color'=>NULL,'time_limit'=>NULL,'is_virtual'=>'0','is_award'=>'0','award_money'=>NULL,'ladder1_num'=>NULL,'ladder1_price'=>NULL,'ladder2_num'=>NULL,'ladder2_price'=>NULL,'is_groups3'=>'0','ladder3_num'=>NULL,'btn_color'=>NULL,'ladder3_price'=>NULL]);
        $this->insert('{{%bea_cloud_activity_groups}}',['id'=>'12','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-15 21:56:55','update_time'=>'2023-03-20 16:24:33','title'=>'测试颜色','desc'=>'<p>23</p>','view_count'=>'36','product_id'=>'22','displayorder'=>'12','is_join'=>'1','start_time'=>'2023-03-15 21:56:18','end_time'=>'2023-03-24 00:00:00','is_cash_audit'=>'1','is_mark'=>'1','music'=>'a:1:{i:0;a:5:{s:4:"name";s:50:"5008_邓寓君(等什么君)-孤勇者(片段).mp3";s:10:"attachment";s:60:"202303/20/5008_邓寓君(等什么君)-孤勇者(片段).mp3";s:3:"url";s:93:"https://bea.ddicms.cn/attachment/202303/20/5008_邓寓君(等什么君)-孤勇者(片段).mp3";s:4:"size";s:7:"1110800";s:3:"uid";s:13:"1679300671206";}}','is_music'=>'1','stock'=>'0','sale_limit'=>'1','thumb'=>'202303/15/4b792869-6e92-3c3c-a8b6-7a4bcaffa519.png','index_thumb'=>'a:1:{i:0;s:50:"202303/15/f5009e32-6524-3ec1-b578-8f88f1b73ed0.png";}','share_thumb'=>'202303/15/3a5ec96c-8398-3a87-a446-ab44a509e33c.png','title_color'=>'#B300FF','bg_color'=>'#EA0707','time_limit'=>'12','is_virtual'=>'1','is_award'=>'0','award_money'=>NULL,'ladder1_num'=>'1','ladder1_price'=>'2.00','ladder2_num'=>'3.00','ladder2_price'=>'4.00','is_groups3'=>'1','ladder3_num'=>'5.00','btn_color'=>'#00E5FF','ladder3_price'=>'6.00']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_activity_groups}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

