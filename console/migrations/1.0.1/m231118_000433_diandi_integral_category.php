<?php

use yii\db\Migration;

class m231118_000433_diandi_integral_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_category}}', [
            'category_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称'",
            'parent_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'image_id' => "varchar(250) NOT NULL",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'goods_id' => "int(11) NULL",
            'wxapp_id' => "int(11) unsigned NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`category_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类管理'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_category}}',['category_id'=>'1','store_id'=>'149','bloc_id'=>'51','name'=>'测试_011','parent_id'=>'0','image_id'=>'202306/15/83a69fc5-1467-35fb-973c-2a666f5e89a4.png','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1686812325','update_time'=>'1686877997']);
        $this->insert('{{%diandi_integral_category}}',['category_id'=>'2','store_id'=>'0','bloc_id'=>'55','name'=>'测试_008','parent_id'=>'0','image_id'=>'202306/15/a987d51e-5a57-3d68-8a50-bb7bdc497825.png','sort'=>'3','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1686812459','update_time'=>'1686878009']);
        $this->insert('{{%diandi_integral_category}}',['category_id'=>'3','store_id'=>'0','bloc_id'=>'0','name'=>'二级分类','parent_id'=>'1','image_id'=>'','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1686897006','update_time'=>'1686897006']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

