<?php

use yii\db\Migration;

class m220801_020131_diandi_website_solution_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_solution_cate}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL",
            'store_id' => "int(11) NOT NULL",
            'name' => "varchar(45) NOT NULL COMMENT '名称'",
            'des' => "varchar(450) NOT NULL COMMENT '描述'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='解决方案分类'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_solution_cate}}',['id'=>'1','bloc_id'=>'8','store_id'=>'61','name'=>'电商','des'=>'电商','created_at'=>'2022-07-06 09:14:52','updated_at'=>'2022-07-06 09:14:52']);
        $this->insert('{{%diandi_website_solution_cate}}',['id'=>'2','bloc_id'=>'8','store_id'=>'61','name'=>'智能房控','des'=>'面向茶室，公寓，酒店管理系统的智能房控家居方案','created_at'=>'2022-07-07 17:12:15','updated_at'=>'2022-07-07 17:12:15']);
        $this->insert('{{%diandi_website_solution_cate}}',['id'=>'3','bloc_id'=>'8','store_id'=>'61','name'=>'音视频','des'=>'音视频直播，通话，外呼解决方案','created_at'=>'2022-07-07 17:12:53','updated_at'=>'2022-07-07 17:12:53']);
        $this->insert('{{%diandi_website_solution_cate}}',['id'=>'4','bloc_id'=>'8','store_id'=>'61','name'=>'企业党建','des'=>'企业内部党建解决方案','created_at'=>'2022-07-07 17:13:21','updated_at'=>'2022-07-07 17:13:21']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_solution_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

