<?php

use yii\db\Migration;

class m221105_121058_migration extends Migration
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
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%migration}}',['version'=>'m000000_000000_base','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_account_log','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_addons','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_ai_sms_log','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_api_access_token','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_api_log','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_auth_assignment','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024926_auth_assignment_group','apply_time'=>'1667642378']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_item','apply_time'=>'1667642406']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_item_child','apply_time'=>'1667642411']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_menu','apply_time'=>'1667642413']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_menu_cate','apply_time'=>'1667642413']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_route','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_rule','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_auth_user_group','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_api','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_app','apply_time'=>'1667642419']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_baidu','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_email','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_map','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_microapp','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_oss','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_sms','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_wechat','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_wechatpay','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_conf_wxapp','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_bloc_level','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_core_paylog','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_dictionary','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_member','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_member_account','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_member_group','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_member_organization','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_message_notice_log','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_pay_refund_log','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_qrcode','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_qrcode_stat','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_queue','apply_time'=>'1667642420']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_region','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_setting','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_store','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_store_category','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_store_label','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_store_label_link','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_swoole_access_token','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_swoole_member','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_swoole_member_copy1','apply_time'=>'1667642431']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_upload_file','apply_time'=>'1667642432']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_upload_file_group','apply_time'=>'1667642432']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_upload_file_used','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_upload_group','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_access_token','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_action_log','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_addons','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_address','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_bloc','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_user_upload_file','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_website_article','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_website_contact','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_website_slide','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_wechat_fans','apply_time'=>'1667642433']);
        $this->insert('{{%migration}}',['version'=>'m221102_024927_wxapp_fans','apply_time'=>'1667642433']);
        
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

