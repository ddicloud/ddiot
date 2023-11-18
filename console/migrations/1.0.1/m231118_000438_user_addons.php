<?php

use yii\db\Migration;

class m231118_000438_user_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_addons}}', [
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
        $this->createIndex('module_name','{{%user_addons}}','module_name',0);
        $this->createIndex('user_id','{{%user_addons}}','user_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%user_addons}}',['id'=>'62','store_id'=>'0','type'=>'1','module_name'=>'diandi_lottery','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'63','store_id'=>'65','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'66','store_id'=>'0','type'=>'1','module_name'=>'diandi_operator','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'71','store_id'=>'0','type'=>'1','module_name'=>'diandi_ai','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'74','store_id'=>'0','type'=>'1','module_name'=>'diandi_cloud','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'75','store_id'=>'0','type'=>'1','module_name'=>'diandi_task','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'76','store_id'=>'0','type'=>'1','module_name'=>'diandi_task','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'77','store_id'=>'0','type'=>'1','module_name'=>'diandi_im','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'78','store_id'=>'0','type'=>'1','module_name'=>'diandi_sms','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'79','store_id'=>'0','type'=>'1','module_name'=>'diandi_example','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'80','store_id'=>'0','type'=>'1','module_name'=>'diandi_tuan','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'82','store_id'=>'0','type'=>'1','module_name'=>'diandi_barter','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'83','store_id'=>'0','type'=>'1','module_name'=>'diandi_shop','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'84','store_id'=>'0','type'=>'1','module_name'=>'diandi_im','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'86','store_id'=>'0','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'87','store_id'=>'0','type'=>'1','module_name'=>'diandi_tuan','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'88','store_id'=>'0','type'=>'1','module_name'=>'diandi_barter','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'89','store_id'=>'0','type'=>'1','module_name'=>'self_help','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'90','store_id'=>'0','type'=>'1','module_name'=>'self_help','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'93','store_id'=>'0','type'=>'1','module_name'=>'diandi_outbound','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'94','store_id'=>'0','type'=>'1','module_name'=>'diandi_integral','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'95','store_id'=>'0','type'=>'1','module_name'=>'diandi_slyder','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'96','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'97','store_id'=>'0','type'=>'1','module_name'=>'diandi_store','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'98','store_id'=>'0','type'=>'1','module_name'=>'diandi_qiniu','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'99','store_id'=>'0','type'=>'1','module_name'=>'diandi_pro','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'100','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'101','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'31','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'102','store_id'=>'0','type'=>'1','module_name'=>'diandi_website','user_id'=>'31','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'103','store_id'=>'0','type'=>'1','module_name'=>'weihai_bigscreen','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'104','store_id'=>'0','type'=>'1','module_name'=>'diandi_honorary','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'105','store_id'=>'0','type'=>'0','module_name'=>'sys','user_id'=>'32','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'106','store_id'=>'77','type'=>'1','module_name'=>'diandi_honorary','user_id'=>'32','is_default'=>'1','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'108','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'110','store_id'=>NULL,'type'=>'0','module_name'=>'sys','user_id'=>'33','is_default'=>'0','status'=>'1','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'111','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'33','is_default'=>'1','status'=>'0','create_time'=>'2022-02-11 10:07:08','update_time'=>'2022-02-11 10:07:08']);
        $this->insert('{{%user_addons}}',['id'=>'116','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_tea','user_id'=>'11','is_default'=>'1','status'=>'1','create_time'=>'2022-03-16 10:35:35','update_time'=>'2022-03-16 10:35:35']);
        $this->insert('{{%user_addons}}',['id'=>'117','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_ai','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'118','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_integral','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'119','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_task','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'120','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_example','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'121','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_shop','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'122','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_outbound','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'123','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_slyder','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'124','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_pro','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'125','store_id'=>NULL,'type'=>'1','module_name'=>'weihai_bigscreen','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'126','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_honorary','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'127','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_party','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'128','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_tea','user_id'=>'1','is_default'=>'0','status'=>'1','create_time'=>'2022-03-28 10:26:11','update_time'=>'2022-03-28 10:26:11']);
        $this->insert('{{%user_addons}}',['id'=>'129','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_project','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-03-30 11:09:24','update_time'=>'2022-03-30 11:09:24']);
        $this->insert('{{%user_addons}}',['id'=>'130','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_project','user_id'=>'36','is_default'=>'1','status'=>'1','create_time'=>'2022-04-06 07:30:54','update_time'=>'2022-04-06 07:30:54']);
        $this->insert('{{%user_addons}}',['id'=>'131','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_farm','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-04-14 16:47:08','update_time'=>'2022-04-14 16:47:08']);
        $this->insert('{{%user_addons}}',['id'=>'132','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_flower','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-04-28 18:26:10','update_time'=>'2022-04-28 18:26:10']);
        $this->insert('{{%user_addons}}',['id'=>'133','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_doorlock','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2022-05-12 18:10:05','update_time'=>'2022-05-12 18:10:05']);
        $this->insert('{{%user_addons}}',['id'=>'134','store_id'=>'80','type'=>'1','module_name'=>'diandi_distribution','user_id'=>'38','is_default'=>'1','status'=>'1','create_time'=>'2022-05-25 18:54:22','update_time'=>'2022-05-25 18:54:22']);
        $this->insert('{{%user_addons}}',['id'=>'135','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_distribution','user_id'=>'38','is_default'=>'0','status'=>'0','create_time'=>'2022-05-25 19:44:51','update_time'=>'2022-05-25 19:44:51']);
        $this->insert('{{%user_addons}}',['id'=>'136','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_flower','user_id'=>'38','is_default'=>'0','status'=>'0','create_time'=>'2022-05-25 20:52:20','update_time'=>'2022-05-25 20:52:20']);
        $this->insert('{{%user_addons}}',['id'=>'139','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_watches','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2022-08-17 16:49:31','update_time'=>'2022-08-17 16:49:31']);
        $this->insert('{{%user_addons}}',['id'=>'164','store_id'=>'86','type'=>'1','module_name'=>'diandi_wristband','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2022-10-28 09:50:36','update_time'=>'2022-10-28 09:50:36']);
        $this->insert('{{%user_addons}}',['id'=>'165','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_switch','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2022-10-28 09:50:36','update_time'=>'2022-10-28 09:50:36']);
        $this->insert('{{%user_addons}}',['id'=>'166','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_hub','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2022-10-28 09:50:36','update_time'=>'2022-10-28 09:50:36']);
        $this->insert('{{%user_addons}}',['id'=>'168','store_id'=>'133','type'=>'1','module_name'=>'diandi_website','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2022-11-09 14:09:32','update_time'=>'2022-11-09 14:09:32']);
        $this->insert('{{%user_addons}}',['id'=>'170','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_hotel','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2023-01-11 11:40:43','update_time'=>'2023-01-11 11:40:43']);
        $this->insert('{{%user_addons}}',['id'=>'171','store_id'=>NULL,'type'=>'1','module_name'=>'bea_cloud','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2023-02-01 13:12:13','update_time'=>'2023-02-01 13:12:13']);
        $this->insert('{{%user_addons}}',['id'=>'172','store_id'=>'136','type'=>'1','module_name'=>'diandi_website','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2023-02-08 16:34:26','update_time'=>'2023-02-08 16:34:26']);
        $this->insert('{{%user_addons}}',['id'=>'173','store_id'=>'138','type'=>'1','module_name'=>'bea_cloud','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2023-02-20 10:49:39','update_time'=>'2023-02-20 10:49:39']);
        $this->insert('{{%user_addons}}',['id'=>'174','store_id'=>'139','type'=>'1','module_name'=>'bea_cloud','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2023-02-20 10:52:00','update_time'=>'2023-02-20 10:52:00']);
        $this->insert('{{%user_addons}}',['id'=>'175','store_id'=>'140','type'=>'1','module_name'=>'bea_cloud','user_id'=>'11','is_default'=>'0','status'=>'1','create_time'=>'2023-02-20 11:20:02','update_time'=>'2023-02-20 11:20:02']);
        $this->insert('{{%user_addons}}',['id'=>'190','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_mall','user_id'=>'11','is_default'=>'0','status'=>'0','create_time'=>'2023-07-04 14:51:13','update_time'=>'2023-07-04 14:51:13']);
        $this->insert('{{%user_addons}}',['id'=>'191','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_hotel','user_id'=>'83','is_default'=>'0','status'=>'0','create_time'=>'2023-10-29 22:40:36','update_time'=>'2023-10-29 22:40:36']);
        $this->insert('{{%user_addons}}',['id'=>'192','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_integral','user_id'=>'83','is_default'=>'0','status'=>'0','create_time'=>'2023-10-29 22:40:36','update_time'=>'2023-10-29 22:40:36']);
        $this->insert('{{%user_addons}}',['id'=>'193','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_mall','user_id'=>'83','is_default'=>'0','status'=>'0','create_time'=>'2023-10-29 22:40:36','update_time'=>'2023-10-29 22:40:36']);
        $this->insert('{{%user_addons}}',['id'=>'197','store_id'=>NULL,'type'=>'1','module_name'=>'diandi_tea','user_id'=>'83','is_default'=>'1','status'=>'0','create_time'=>'2023-11-01 20:06:47','update_time'=>'2023-11-01 20:06:47']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_addons}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

