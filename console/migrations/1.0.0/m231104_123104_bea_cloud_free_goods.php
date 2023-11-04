<?php

use yii\db\Migration;

class m231104_123104_bea_cloud_free_goods extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_free_goods}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'free_id' => "int(11) NULL COMMENT '活动ID'",
            'inventory' => "int(11) NULL COMMENT '库存'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'12','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:31:07','update_time'=>'2023-03-16 19:31:07','goods_id'=>'23','free_id'=>'11','inventory'=>'6']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'11','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 19:31:07','update_time'=>'2023-03-16 19:31:07','goods_id'=>'22','free_id'=>'11','inventory'=>'8']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'10','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 09:53:53','update_time'=>'2023-03-16 09:53:53','goods_id'=>'23','free_id'=>'10','inventory'=>'5']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'9','store_id'=>'149','bloc_id'=>'51','create_time'=>'2023-03-16 09:53:53','update_time'=>'2023-03-16 09:53:53','goods_id'=>'22','free_id'=>'10','inventory'=>'10']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'8','store_id'=>'143','bloc_id'=>'39','create_time'=>'2023-03-09 21:17:56','update_time'=>'2023-03-09 21:17:56','goods_id'=>'21','free_id'=>'9','inventory'=>'2']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'7','store_id'=>'138','bloc_id'=>'38','create_time'=>'2023-03-07 16:23:09','update_time'=>'2023-03-07 16:23:09','goods_id'=>'21','free_id'=>'7','inventory'=>'23']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'13','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-18 09:46:55','update_time'=>'2023-03-18 09:46:55','goods_id'=>'22','free_id'=>'12','inventory'=>'23']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'14','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-18 09:46:55','update_time'=>'2023-03-18 09:46:55','goods_id'=>'23','free_id'=>'12','inventory'=>'2']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'15','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-18 15:22:22','update_time'=>'2023-03-18 15:22:22','goods_id'=>'22','free_id'=>'13','inventory'=>'1']);
        $this->insert('{{%bea_cloud_free_goods}}',['id'=>'16','store_id'=>'151','bloc_id'=>'51','create_time'=>'2023-03-18 15:22:22','update_time'=>'2023-03-18 15:22:22','goods_id'=>'23','free_id'=>'13','inventory'=>'2']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_free_goods}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

