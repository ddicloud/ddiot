<?php

use yii\db\Migration;

class m231104_123105_migration extends Migration
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
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%migration}}',['version'=>'m000000_000000_base','apply_time'=>'1640694817']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_account_log','apply_time'=>'1640694819']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_addons','apply_time'=>'1640694819']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_addons_store','apply_time'=>'1640694819']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_addons_user','apply_time'=>'1640694819']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_ai_sms_log','apply_time'=>'1640694819']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_api_access_token','apply_time'=>'1640694821']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_api_log','apply_time'=>'1640694821']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_assignment','apply_time'=>'1640694821']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_assignment_group','apply_time'=>'1640694821']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_backend_menu','apply_time'=>'1640694822']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_item','apply_time'=>'1640694822']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_item_child','apply_time'=>'1640694825']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_menu','apply_time'=>'1640694825']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_menu_cate','apply_time'=>'1640694825']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_route','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_rule','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_auth_user_group','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_app','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_baidu','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_email','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_map','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_microapp','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_oss','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_sms','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_wechat','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_wechatpay','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_conf_wxapp','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_bloc_level','apply_time'=>'1640694829']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_core_paylog','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_dictionary','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_member','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_member_account','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_member_group','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_member_organization','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_message_notice_log','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_pay_refund_log','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_qrcode','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_qrcode_stat','apply_time'=>'1640694830']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_region','apply_time'=>'1640694848']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_setting','apply_time'=>'1640694848']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_store','apply_time'=>'1640694848']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_store_category','apply_time'=>'1640694848']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_store_label','apply_time'=>'1640694848']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_store_label_link','apply_time'=>'1640694849']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_upload_file','apply_time'=>'1640694866']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_upload_file_group','apply_time'=>'1640694866']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_upload_file_used','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_upload_file_user','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_upload_group','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_user','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_user_access_token','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_user_address','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_user_bloc','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_website_article','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_website_article_category','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_website_contact','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_website_slide','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_wechat_fans','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_weihai_bigscreen_ceshi','apply_time'=>'1640694867']);
        $this->insert('{{%migration}}',['version'=>'m211228_104930_wxapp_fans','apply_time'=>'1640694867']);
        
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

