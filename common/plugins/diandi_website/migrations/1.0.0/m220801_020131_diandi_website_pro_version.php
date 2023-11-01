<?php

use yii\db\Migration;

class m220801_020131_diandi_website_pro_version extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_pro_version}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'link' => "varchar(255) NULL COMMENT '链接地址'",
            'image' => "varchar(255) NULL COMMENT '静止图片'",
            'b_image' => "varchar(255) NULL COMMENT '鼠标悬停图片'",
            'title' => "varchar(100) NULL COMMENT '标题'",
            'content' => "varchar(255) NULL COMMENT '内容'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品版本'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_pro_version}}',['id'=>'18','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-23 11:35:08','update_time'=>'2022-07-14 14:59:03','link'=>'','image'=>'202207/14/75604c19-0a77-3fc2-8836-39db19f6fe77.png','b_image'=>'202207/14/a1f72d66-2684-3be4-b0ac-257f0beb9a9a.png','title'=>'私有化部署版','content'=>'一次买断，提供加密版和开源版']);
        $this->insert('{{%diandi_website_pro_version}}',['id'=>'19','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-23 11:43:58','update_time'=>'2022-07-14 14:59:14','link'=>'','image'=>'202207/14/5d0199ce-d533-3e76-b5a2-a175f7cf23fb.png','b_image'=>'202207/14/1f292baf-1475-3baa-86c0-cabded4be059.png','title'=>'SASS版','content'=>'按年续费']);
        $this->insert('{{%diandi_website_pro_version}}',['id'=>'20','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-23 11:44:26','update_time'=>'2022-07-14 14:59:27','link'=>'','image'=>'202207/14/1b859e13-66f4-3d17-b27b-ee883f3afe06.png','b_image'=>'202207/14/e4e26907-f59e-3c01-9086-c735521760e1.png','title'=>'品牌授权版','content'=>'
云服务器
']);
        $this->insert('{{%diandi_website_pro_version}}',['id'=>'21','store_id'=>'61','bloc_id'=>'8','create_time'=>'2022-06-23 11:44:44','update_time'=>'2022-07-14 15:00:11','link'=>'','image'=>'202207/14/c83d12cf-d389-398d-8ad5-de31c28547df.png','b_image'=>'202207/14/656d481c-03f8-3b2c-bd0a-0fee6441b5b4.png','title'=>'定制开发版','content'=>'云帮助文档']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_pro_version}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

