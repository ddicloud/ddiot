<?php

use yii\db\Migration;

class m221018_094926_diandi_cloud_addons_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_cloud_addons_cate}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '上级 ID'",
            'name' => "varchar(45) NOT NULL COMMENT '分类名称'",
            'sort' => "int(11) NOT NULL DEFAULT '0' COMMENT '排序值'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_cloud_addons_cate}}',['id'=>'1','pid'=>'2','name'=>'132','sort'=>'0','created_at'=>'2022-07-06 16:08:19','updated_at'=>'2022-07-06 15:57:06']);
        $this->insert('{{%diandi_cloud_addons_cate}}',['id'=>'2','pid'=>'0','name'=>'zhang','sort'=>'0','created_at'=>'2022-07-06 15:57:26','updated_at'=>'2022-07-06 15:57:26']);
        $this->insert('{{%diandi_cloud_addons_cate}}',['id'=>'3','pid'=>'0','name'=>'132','sort'=>'0','created_at'=>'2022-07-06 16:01:53','updated_at'=>'2022-07-06 16:01:53']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_cloud_addons_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

