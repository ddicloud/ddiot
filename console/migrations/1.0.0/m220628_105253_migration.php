<?php

use yii\db\Migration;

class m220628_105253_migration extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%migration}}', [
            'version' => "varchar(180) NOT NULL",
            'apply_time' => "int(11) NULL",
            'PRIMARY KEY (`version`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%migration}}',['version'=>'m000000_000000_base','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_account_log','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_addons','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_addons_store','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_addons_user','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_ai_sms_log','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_api_access_token','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_api_log','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_assignment','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_assignment_group','apply_time'=>'1656410168']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_item','apply_time'=>'1656410183']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_item_child','apply_time'=>'1656410186']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_menu','apply_time'=>'1656410186']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_menu_cate','apply_time'=>'1656410186']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_route','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_rule','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_auth_user_group','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_app','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_baidu','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_email','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_map','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_microapp','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_oss','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_sms','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_wechat','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_wechatpay','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_conf_wxapp','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_bloc_level','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063635_c_auto_8','apply_time'=>'1656410190']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_core_paylog','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_dictionary','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_member','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_member_account','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_member_group','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_member_organization','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_message_notice_log','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_pay_refund_log','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_qrcode','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_qrcode_stat','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_queue','apply_time'=>'1656410191']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_region','apply_time'=>'1656410208']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_setting','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_store','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_store_category','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_store_label','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_store_label_link','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_upload_file','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_upload_file_group','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_upload_file_used','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_upload_file_user','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_upload_group','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_user','apply_time'=>'1656410209']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_user_access_token','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_user_address','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_user_bloc','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_website_article','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_website_article_category','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_website_contact','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_website_slide','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_wechat_fans','apply_time'=>'1656410210']);
        $this->insert('{{%migration}}',['version'=>'m220613_063636_wxapp_fans','apply_time'=>'1656410210']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%migration}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

