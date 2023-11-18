<?php

use yii\db\Migration;

class m231118_000434_diandi_tea_test_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_test_member}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '人脸招聘'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'member_id' => "int(11) NULL COMMENT '测试用户id'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='全局配置表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_test_member}}',['id'=>'6','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 16:58:05','update_time'=>'2022-04-24 09:50:37','member_id'=>'202204']);
        $this->insert('{{%diandi_tea_test_member}}',['id'=>'8','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 16:58:05','update_time'=>'2022-03-31 16:58:05','member_id'=>'202203']);
        $this->insert('{{%diandi_tea_test_member}}',['id'=>'9','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 16:58:05','update_time'=>'2022-06-02 17:44:57','member_id'=>'202204']);
        $this->insert('{{%diandi_tea_test_member}}',['id'=>'10','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 16:58:05','update_time'=>'2022-03-31 16:58:05','member_id'=>'202203']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_test_member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

