<?php

use yii\db\Migration;

class m231118_000438_member_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%member_group}}', [
            'group_id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'level' => "int(11) NULL COMMENT '等级权重'",
            'item_name' => "varchar(64) NOT NULL COMMENT '名称'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`group_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%member_group}}',['group_id'=>'2','bloc_id'=>NULL,'store_id'=>NULL,'level'=>'2','item_name'=>'组1','create_time'=>'1659941698','update_time'=>'1659941698']);
        $this->insert('{{%member_group}}',['group_id'=>'3','bloc_id'=>NULL,'store_id'=>NULL,'level'=>'3','item_name'=>'组2','create_time'=>'1659941731','update_time'=>'1659941731']);
        $this->insert('{{%member_group}}',['group_id'=>'4','bloc_id'=>'31','store_id'=>'80','level'=>'1','item_name'=>'会员组A','create_time'=>'1659942252','update_time'=>'1659942252']);
        $this->insert('{{%member_group}}',['group_id'=>'5','bloc_id'=>'8','store_id'=>'61','level'=>'1','item_name'=>'普通会员','create_time'=>'1659944392','update_time'=>'1659944392']);
        $this->insert('{{%member_group}}',['group_id'=>'11','bloc_id'=>'8','store_id'=>'61','level'=>'0','item_name'=>'普通会员','create_time'=>'1659945818','update_time'=>'1659945818']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%member_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

