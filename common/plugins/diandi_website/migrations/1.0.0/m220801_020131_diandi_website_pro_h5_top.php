<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_h5_top extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_h5_top}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'image' => "varchar(255) NULL COMMENT '静止图片'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'logo_a' => "varchar(255) NULL COMMENT '静止logo'",
            'logo_b' => "varchar(255) NULL COMMENT '鼠标悬停logo'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='h5前端界面展示'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_h5_top}}',['id'=>'17','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-07 16:30:25','update_time'=>'2022-06-07 16:31:31','image'=>'202206/07/cb0c29a8-32c4-3d0e-b7d5-130ba5c8d0bd.jpg','title'=>'标题1','logo_a'=>'202206/07/670bdac9-af32-38cb-8f81-b61e5a108722.jpg','logo_b'=>'202206/07/819296f1-6f16-360d-886b-9593da38c95f.jpg']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_h5_top}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

