<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_base_goods_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_base_goods_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'goods_id' => "int(11) NULL",
            'link_store_id' => "int(11) NULL",
            'link_bloc_id' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED COMMENT='活动统一规则'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'11','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'21','link_store_id'=>'140','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'10','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'20','link_store_id'=>'138','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'9','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'20','link_store_id'=>'140','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'8','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'19','link_store_id'=>'141','link_bloc_id'=>'43']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'5','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'17','link_store_id'=>'141','link_bloc_id'=>'43']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'6','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'17','link_store_id'=>'138','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'7','store_id'=>'139','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'17','link_store_id'=>'139','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'12','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'21','link_store_id'=>'138','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'13','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'21','link_store_id'=>'139','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'14','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'21','link_store_id'=>'137','link_bloc_id'=>'38']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'67','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'25','link_store_id'=>'151','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'64','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'22','link_store_id'=>'149','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'46','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'23','link_store_id'=>'149','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'45','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'23','link_store_id'=>'150','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'44','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'23','link_store_id'=>'153','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'63','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'22','link_store_id'=>'150','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'58','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'24','link_store_id'=>'152','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'57','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'24','link_store_id'=>'151','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'66','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'25','link_store_id'=>'150','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'65','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'25','link_store_id'=>'149','link_bloc_id'=>'51']);
        $this->insert('{{%bea_cloud_base_goods_store}}',['id'=>'70','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-11-04 19:36:59','update_time'=>'2023-11-04 19:36:59','goods_id'=>'26','link_store_id'=>'150','link_bloc_id'=>'51']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_base_goods_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

