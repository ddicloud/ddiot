<?php

use yii\db\Migration;

class m221105_121058_auth_menu_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_menu_cate}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(255) NULL",
            'mark' => "varchar(255) NULL",
            'sort' => "int(11) NULL",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'icon' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%auth_menu_cate}}',['id'=>'1','name'=>'系统','mark'=>'sysai','sort'=>'1','create_time'=>'1580017720','update_time'=>'1580016659','icon'=>'fa fa-fw fa-home']);
        $this->insert('{{%auth_menu_cate}}',['id'=>'2','name'=>'权限','mark'=>'auth','sort'=>'2','create_time'=>'1580017890','update_time'=>'1580016673','icon'=>'fa fa-fw fa-eye']);
        $this->insert('{{%auth_menu_cate}}',['id'=>'3','name'=>'会员','mark'=>'member','sort'=>'3','create_time'=>'1580017910','update_time'=>'1580016684','icon'=>'fa fa-fw fa-user-plus']);
        $this->insert('{{%auth_menu_cate}}',['id'=>'4','name'=>'集团','mark'=>'bloc','sort'=>'1','create_time'=>'','update_time'=>'','icon'=>'65']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_menu_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

