<?php

use yii\db\Migration;

class m220628_105253_auth_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_menu}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(128) NOT NULL",
            'parent' => "int(11) NOT NULL",
            'route_id' => "int(11) NULL COMMENT '路由ID'",
            'route' => "varchar(255) NULL",
            'order' => "int(11) NOT NULL DEFAULT '0'",
            'data' => "blob NULL",
            'type' => "varchar(20) NULL",
            'level_type' => "int(11) NULL",
            'icon' => "varchar(30) NULL",
            'is_sys' => "varchar(30) NULL DEFAULT 'system'",
            'module_name' => "varchar(30) NULL",
            'is_show' => "smallint(6) NULL DEFAULT '1' COMMENT '是否显示'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('parent','{{%auth_menu}}','parent',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_menu}}',['id'=>'1','name'=>'权限','parent'=>'27','route_id'=>'3453','route'=>'/main/index.vue','order'=>'1','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'el-dd-deleteteam','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'2','name'=>'权限维护','parent'=>'1','route_id'=>'59','route'=>'/admin/permission/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'3','name'=>'菜单路由','parent'=>'1','route_id'=>'76','route'=>'/admin/route/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'4','name'=>'用户组','parent'=>'27','route_id'=>'39','route'=>'/admin/group/index','order'=>'2','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'el-dd-addteam','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'6','name'=>'系统菜单','parent'=>'75','route_id'=>'46','route'=>'/admin/menu/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'el-dd-menu','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'9','name'=>'权限规则','parent'=>'1','route_id'=>'83','route'=>'/admin/rule/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'25','name'=>'会员','parent'=>'0','route_id'=>'367','route'=>'/member/dd-member/index','order'=>'5','data'=>NULL,'type'=>'member','level_type'=>'1','icon'=>'el-dd-idcard','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'27','name'=>'管理员','parent'=>'0','route_id'=>'99','route'=>'/admin/user/index','order'=>'4','data'=>NULL,'type'=>'auth','level_type'=>'1','icon'=>'el-dd-switchuser','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'28','name'=>'管理员','parent'=>'27','route_id'=>'99','route'=>'/admin/user/index','order'=>'3','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'el-dd-switchuser','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'39','name'=>'站点管理','parent'=>'75','route_id'=>'3453','route'=>'/main/index.vue','order'=>'2','data'=>NULL,'type'=>'sysai','level_type'=>'3','icon'=>'el-dd-desktop','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'40','name'=>'幻灯片','parent'=>'39','route_id'=>'424','route'=>'/website/dd-website-slide/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'44','name'=>'联系我们','parent'=>'39','route_id'=>'417','route'=>'/website/dd-website-contact/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'45','name'=>'系统路由','parent'=>'1','route_id'=>'3100','route'=>'/admin/route/init','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'46','name'=>'会员管理','parent'=>'25','route_id'=>'367','route'=>'/member/dd-member/index','order'=>'0','data'=>NULL,'type'=>'member','level_type'=>'4','icon'=>'el-dd-idcard','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'49','name'=>'会员组','parent'=>'25','route_id'=>'374','route'=>'/member/dd-member-group/index','order'=>'0','data'=>NULL,'type'=>'member','level_type'=>'4','icon'=>'el-dd-team','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'75','name'=>'系统','parent'=>'0','route_id'=>'381','route'=>'/system/index/index','order'=>'3','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'el-dd-setting','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'197','name'=>'站点设置','parent'=>'39','route_id'=>'430','route'=>'/website/setting/website','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'222','name'=>'公司管理','parent'=>'531','route_id'=>'3453','route'=>'/main/index.vue','order'=>'1','data'=>NULL,'type'=>'sysai','level_type'=>'3','icon'=>'el-dd-jituan','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'254','name'=>'业务','parent'=>'0','route_id'=>'131','route'=>'/addons/addons/index','order'=>'1','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'el-dd-plus-square','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'531','name'=>'集团','parent'=>'0','route_id'=>'1518','route'=>'/addons/bloc/index','order'=>'2','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'el-dd-apartment','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'532','name'=>'商户类型','parent'=>'997','route_id'=>'3096','route'=>'/addons/store/category/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'943','name'=>'公司等级','parent'=>'222','route_id'=>'3092','route'=>'/addons/bloc/bloclevel/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'947','name'=>'商户管理','parent'=>'997','route_id'=>'3095','route'=>'/addons/store/list/index','order'=>'1','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'949','name'=>'商户标签','parent'=>'997','route_id'=>'3097','route'=>'/addons/store/storelabel/index','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'993','name'=>'公司配置','parent'=>'222','route_id'=>'3094','route'=>'/addons/bloc/blocset/index','order'=>'1','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'996','name'=>'公司管理','parent'=>'222','route_id'=>'3093','route'=>'/addons/bloc/list/index','order'=>'1','data'=>NULL,'type'=>NULL,'level_type'=>'5','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'997','name'=>'商户','parent'=>'531','route_id'=>'3453','route'=>'/main/index.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'3','icon'=>'el-dd-shanghupiliangruzhu','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'998','name'=>'工作台','parent'=>'0','route_id'=>'3098','route'=>'/dashboard','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'1','icon'=>'el-dd-appstoreadd','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'999','name'=>'工作台','parent'=>'998','route_id'=>'3098','route'=>'/dashboard','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'el-dd-appstoreadd','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1018','name'=>'我的业务','parent'=>'254','route_id'=>'131','route'=>'/addons/addons/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'4','icon'=>'el-dd-plus-square','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1024','name'=>'公司详情','parent'=>'996','route_id'=>'3450','route'=>'/addons/bloc/list/bloc-view.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1025','name'=>'文章管理','parent'=>'39','route_id'=>'320','route'=>'/article/dd-article/index','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1028','name'=>'文章列表','parent'=>'1025','route_id'=>'320','route'=>'/article/dd-article/index','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'5','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1043','name'=>'组织架构','parent'=>'25','route_id'=>'3462','route'=>'/member/dd-member/member-organization.vue','order'=>'3','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'el-dd-Partition','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1068','name'=>'系统配置','parent'=>'75','route_id'=>'3481','route'=>'/system/settings/index.vue','order'=>'1','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'el-dd-setting','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1098','name'=>'初始商户','parent'=>'997','route_id'=>'3517','route'=>'/addons/store/welcome/index.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1186','name'=>'添加文章','parent'=>'1028','route_id'=>'322','route'=>'/article/dd-article/create','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1368','name'=>'更多业务','parent'=>'254','route_id'=>'4153','route'=>'/addons/addons/install.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'el-dd-jituan','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

