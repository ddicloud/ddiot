<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_comment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_comment}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'type' => "int(11) NULL COMMENT '评价类型'",
            'user_id' => "int(11) NULL COMMENT '评论人'",
            'comment' => "varchar(255) NULL COMMENT '评论内容'",
            'comment_id' => "int(11) NULL",
            'images' => "varchar(255) NULL",
            'update_time' => "int(30) NULL",
            'create_time' => "int(30) NULL COMMENT '评论时间'",
            'status' => "tinyint(255) NULL DEFAULT '0' COMMENT '是否审核'",
            'star_level' => "int(11) NULL COMMENT '星级'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='商家评论'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_comment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

