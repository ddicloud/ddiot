<?php

use yii\db\Migration;

class m220228_021726_addons_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addons_user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL COMMENT '默认商户'",
            'type' => "smallint(6) NULL COMMENT '用户类型'",
            'module_name' => "varchar(50) NULL COMMENT '所属模块'",
            'user_id' => "int(11) NULL COMMENT '用户id'",
            'is_default' => "int(11) NULL DEFAULT '0' COMMENT '是否默认'",
            'status' => "smallint(6) NULL COMMENT '审核状态'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='扩展模块用户表'");
        
        /* 索引设置 */
        $this->createIndex('module_name','{{%addons_user}}','module_name',0);
        $this->createIndex('user_id','{{%addons_user}}','user_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%addons_user}}',['id'=>'37','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'20','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'62','store_id'=>'0','type'=>'1','module_name'=>'diandi_lottery','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'63','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'66','store_id'=>'0','type'=>'1','module_name'=>'diandi_operator','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'69','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'20','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'71','store_id'=>'0','type'=>'1','module_name'=>'diandi_ai','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'72','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'22','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'74','store_id'=>'0','type'=>'1','module_name'=>'diandi_cloud','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'75','store_id'=>'0','type'=>'1','module_name'=>'diandi_task','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'76','store_id'=>'0','type'=>'1','module_name'=>'diandi_task','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'77','store_id'=>'0','type'=>'1','module_name'=>'diandi_im','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'78','store_id'=>'0','type'=>'1','module_name'=>'diandi_sms','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'79','store_id'=>'0','type'=>'1','module_name'=>'diandi_example','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'80','store_id'=>'0','type'=>'1','module_name'=>'diandi_tuan','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'81','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'23','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'82','store_id'=>'0','type'=>'1','module_name'=>'diandi_barter','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'83','store_id'=>'0','type'=>'1','module_name'=>'diandi_shop','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'84','store_id'=>'0','type'=>'1','module_name'=>'diandi_im','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'86','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'87','store_id'=>'0','type'=>'1','module_name'=>'diandi_tuan','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'88','store_id'=>'0','type'=>'1','module_name'=>'diandi_barter','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'89','store_id'=>'0','type'=>'1','module_name'=>'self_help','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'90','store_id'=>'0','type'=>'1','module_name'=>'self_help','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'91','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'29','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'92','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'30','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'93','store_id'=>'0','type'=>'1','module_name'=>'diandi_outbound','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'94','store_id'=>'0','type'=>'1','module_name'=>'diandi_integral','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'95','store_id'=>'0','type'=>'1','module_name'=>'diandi_slyder','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'96','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'97','store_id'=>'0','type'=>'1','module_name'=>'diandi_store','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'98','store_id'=>'0','type'=>'1','module_name'=>'diandi_qiniu','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'99','store_id'=>'0','type'=>'1','module_name'=>'diandi_pro','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'100','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'101','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'31','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'102','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'31','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'103','store_id'=>'0','type'=>'1','module_name'=>'weihai_bigscreen','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'104','store_id'=>'0','type'=>'1','module_name'=>'diandi_honorary','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'105','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'32','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'106','store_id'=>'77','type'=>'1','module_name'=>'diandi_honorary','user_id'=>'32','is_default'=>'1','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'107','store_id'=>'0','type'=>'1','module_name'=>'diandi_honorary','user_id'=>'29','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'108','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'109','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'29','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'110','store_id'=>NULL,'type'=>'0','module_name'=>'sys','user_id'=>'33','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%addons_user}}',['id'=>'111','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'33','is_default'=>'1','status'=>'0','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addons_user}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

