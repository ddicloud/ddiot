<?php

use yii\db\Migration;

class m221018_094926_diandi_cloud_addons extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_cloud_addons}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模块id'",
            'is_nav' => "int(11) NULL COMMENT '是否导航'",
            'identifie' => "varchar(100) NOT NULL COMMENT '英文标识'",
            'type' => "varchar(30) NULL DEFAULT 'base' COMMENT '模块类型'",
            'title' => "varchar(100) NOT NULL COMMENT '名称'",
            'version' => "varchar(15) NOT NULL COMMENT '版本'",
            'ability' => "varchar(500) NOT NULL COMMENT '简介'",
            'description' => "varchar(1000) NOT NULL COMMENT '描述'",
            'author' => "varchar(50) NOT NULL COMMENT '作者'",
            'url' => "varchar(255) NOT NULL COMMENT '社区地址'",
            'settings' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '配置'",
            'logo' => "varchar(250) NOT NULL COMMENT 'logo'",
            'versions' => "varchar(50) NULL COMMENT '适应的软件版本'",
            'is_install' => "tinyint(1) NULL",
            'parent_mids' => "varchar(250) NULL DEFAULT '0'",
            'cate_id' => "int(11) NOT NULL COMMENT '分类ID'",
            'applets' => "varchar(180) NOT NULL DEFAULT '' COMMENT '小程序二维码'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='扩展模块表'");
        
        /* 索引设置 */
        $this->createIndex('idx_name','{{%diandi_cloud_addons}}','identifie',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'132','is_nav'=>NULL,'identifie'=>'diandi_im','type'=>'base','title'=>'店滴客服','version'=>'1.0','ability'=>'实时在线客服聊天','description'=>'实时在线客服聊天','author'=>'chunchun','url'=>'https://www.hopesfire.com/','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_im','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'133','is_nav'=>NULL,'identifie'=>'diandi_ai','type'=>'base','title'=>'店滴AI','version'=>'1.0','ability'=>'店滴ai','description'=>'人脸识别，OCR认证，人脸会员等','author'=>'王春生','url'=>'http://bbs.wayfirer.com/','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_ai','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'135','is_nav'=>NULL,'identifie'=>'diandi_integral','type'=>'business','title'=>'积分商城','version'=>'0.1','ability'=>'积分商城','description'=>'积分商城','author'=>'tuhuokeji','url'=>'','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_integral','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'140','is_nav'=>NULL,'identifie'=>'diandi_distribution','type'=>'base','title'=>'店滴分销','version'=>'1.0.0','ability'=>'1','description'=>'分销','author'=>'wanchunsheng','url'=>'www.baidu.com','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_distribution','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'141','is_nav'=>NULL,'identifie'=>'diandi_task','type'=>'base','title'=>'任务调度','version'=>'1.0','ability'=>'结合swoole完成定时任务调度','description'=>'结合swoole完成定时任务调度','author'=>'chunchun','url'=>'https://www.hopesfire.com/','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_task','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'2','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'145','is_nav'=>NULL,'identifie'=>'diandi_example','type'=>'base','title'=>'开发文档','version'=>'1.0','ability'=>'店滴官方开发示例','description'=>'店滴各种组件开发示例','author'=>'店滴','url'=>'https://gitee.com/wayfiretech_admin/firetech','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_example','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'2','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'147','is_nav'=>NULL,'identifie'=>'diandi_tuan','type'=>'base','title'=>'店滴拼团','version'=>'1.0','ability'=>'店滴拼团','description'=>'店滴拼团','author'=>'店滴','url'=>'https://gitee.com/wayfiretech_admin/firetech','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_tuan','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'2','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'152','is_nav'=>NULL,'identifie'=>'diandi_shop','type'=>'business','title'=>'店滴点单','version'=>'1.3.8','ability'=>'店滴点单','description'=>'店滴点单','author'=>'tuhuokeji','url'=>'','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_shop','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'2','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'154','is_nav'=>NULL,'identifie'=>'diandi_outbound','type'=>'marketing','title'=>'外呼系统','version'=>'1.0','ability'=>'外呼系统','description'=>'外呼系统','author'=>'王春生','url'=>'','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_outbound','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'2','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'155','is_nav'=>NULL,'identifie'=>'diandi_slyder','type'=>'marketing','title'=>'大转盘','version'=>'1.0.0','ability'=>'大转盘','description'=>'大转盘活动','author'=>'王春生','url'=>'','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_slyder','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'156','is_nav'=>NULL,'identifie'=>'diandi_website','type'=>'base','title'=>'内容cms','version'=>'1.0.0','ability'=>'企业官网管理','description'=>'','author'=>'','url'=>'','settings'=>'0','logo'=>'/backend/addons/addons/logo?addon=diandi_website','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'140,163','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'159','is_nav'=>NULL,'identifie'=>'diandi_pro','type'=>'buss','title'=>'产品库维护','version'=>'1.0','ability'=>'1','description'=>'工业产品库维护','author'=>'wangchunsheng','url'=>'http://bbs.wayfirer.com/','settings'=>'0','logo'=>'diandi_pro/logo.png','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'160','is_nav'=>NULL,'identifie'=>'weihai_bigscreen','type'=>'base','title'=>'疫情城市防控','version'=>'1.0.0','ability'=>'微嗨数据大屏','description'=>'微嗨数据大屏','author'=>'chunchun','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'162','is_nav'=>NULL,'identifie'=>'diandi_honorary','type'=>'base','title'=>'晓多荣誉墙','version'=>'1.0','ability'=>'晓多荣誉墙','description'=>'晓多荣誉墙','author'=>'王春生','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'163','is_nav'=>NULL,'identifie'=>'diandi_party','type'=>'base','title'=>'企业党建','version'=>'1.0.0','ability'=>'企业内部党建','description'=>'企业内部党建','author'=>'chunchun','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'164','is_nav'=>NULL,'identifie'=>'diandi_tea','type'=>'base','title'=>'智能茶室','version'=>'1.0.0','ability'=>'智能茶室','description'=>'智能茶室','author'=>'兔兔','url'=>'3','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'165','is_nav'=>NULL,'identifie'=>'diandi_project','type'=>'base','title'=>'工程管理','version'=>'1.0','ability'=>'工程管理','description'=>'工程管理','author'=>'chunchun','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'166','is_nav'=>NULL,'identifie'=>'diandi_farm','type'=>'base','title'=>'农业牧养','version'=>'1.0.0','ability'=>'农业牧养','description'=>'农业牧养','author'=>'兔兔','url'=>'3','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'140','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'167','is_nav'=>NULL,'identifie'=>'diandi_flower','type'=>'base','title'=>'花卉市场','version'=>'1.0.0','ability'=>'昆明花卉','description'=>'昆明花卉','author'=>'兔兔','url'=>'1','settings'=>'0','logo'=>'132312','versions'=>'null','is_install'=>'1','parent_mids'=>'140','cate_id'=>'1','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'171','is_nav'=>NULL,'identifie'=>'diandi_doorlock','type'=>'base','title'=>'智能门锁','version'=>'1.0.0','ability'=>'智能门锁','description'=>'智能门锁','author'=>'王春生','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'184','is_nav'=>NULL,'identifie'=>'diandi_switch','type'=>'base','title'=>'智能开关','version'=>'1.0.0','ability'=>'智能开关','description'=>'智能开关','author'=>'王春生','url'=>'','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        $this->insert('{{%diandi_cloud_addons}}',['id'=>'186','is_nav'=>NULL,'identifie'=>'diandi_cloud','type'=>'bus','title'=>'店滴云','version'=>'1.0.0','ability'=>'店滴独立模块授权管理系统','description'=>'店滴独立模块授权管理系统','author'=>'chunchun','url'=>'https://www.hopesfire.com/','settings'=>'0','logo'=>'','versions'=>NULL,'is_install'=>NULL,'parent_mids'=>'0','cate_id'=>'0','applets'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_cloud_addons}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

