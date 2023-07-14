<?php

use yii\db\Migration;

class m230714_032924_auth_menu extends Migration
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
            'is_show' => "smallint(6) NULL DEFAULT '1' COMMENT '是否显示0显示'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('parent','{{%auth_menu}}','parent',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_menu}}',['id'=>'1','name'=>'权限','parent'=>'75','route_id'=>'3453','route'=>'/main/index.vue','order'=>'1','data'=>NULL,'type'=>'auth','level_type'=>'3','icon'=>'sys-limits-of-authority','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'2','name'=>'权限维护','parent'=>'1','route_id'=>'59','route'=>'/admin/permission/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'5','icon'=>'sys-Permission-maintenance','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'3','name'=>'菜单路由','parent'=>'1','route_id'=>'76','route'=>'/admin/route/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'5','icon'=>'sys-Menu Routing','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'4','name'=>'用户组','parent'=>'27','route_id'=>'39','route'=>'/admin/group/index','order'=>'2','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'sys-User-Group','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'6','name'=>'系统菜单','parent'=>'75','route_id'=>'46','route'=>'/admin/menu/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'sys-system-menu','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'9','name'=>'权限规则','parent'=>'1','route_id'=>'83','route'=>'/admin/rule/index','order'=>'0','data'=>NULL,'type'=>'auth','level_type'=>'5','icon'=>'sys-Menu-Routing-44','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'25','name'=>'会员','parent'=>'0','route_id'=>'367','route'=>'/member/dd-member/index','order'=>'5','data'=>NULL,'type'=>'member','level_type'=>'1','icon'=>'hotel-Branding','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'27','name'=>'管理员','parent'=>'0','route_id'=>'99','route'=>'/admin/user/index','order'=>'4','data'=>NULL,'type'=>'auth','level_type'=>'1','icon'=>'sys-administrators','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'28','name'=>'管理员','parent'=>'27','route_id'=>'99','route'=>'/admin/user/index','order'=>'3','data'=>NULL,'type'=>'auth','level_type'=>'4','icon'=>'sys-administrators','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'46','name'=>'会员管理','parent'=>'25','route_id'=>'367','route'=>'/member/dd-member/index','order'=>'0','data'=>NULL,'type'=>'member','level_type'=>'4','icon'=>'sys-Company-level','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'49','name'=>'会员组','parent'=>'25','route_id'=>'374','route'=>'/member/dd-member-group/index','order'=>'0','data'=>NULL,'type'=>'member','level_type'=>'4','icon'=>'sys-Member-Group','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'75','name'=>'系统','parent'=>'0','route_id'=>'381','route'=>'/system/index/index','order'=>'3','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'sys-system','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'197','name'=>'站点信息','parent'=>'75','route_id'=>'430','route'=>'/website/setting/website.vue','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'4','icon'=>'sys-site-information','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'222','name'=>'公司管理','parent'=>'531','route_id'=>'3453','route'=>'/main/index.vue','order'=>'1','data'=>NULL,'type'=>'sysai','level_type'=>'3','icon'=>'sys-Company-management','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'254','name'=>'业务','parent'=>'0','route_id'=>'131','route'=>'/addons/addons/index','order'=>'1','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'sys-my-business','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'531','name'=>'集团','parent'=>'0','route_id'=>'1518','route'=>'/addons/bloc/index','order'=>'2','data'=>NULL,'type'=>'sysai','level_type'=>'1','icon'=>'sys-Company-management','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'532','name'=>'商户类型','parent'=>'997','route_id'=>'3096','route'=>'/addons/store/category/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'sys-Merchant-type','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'943','name'=>'公司等级','parent'=>'222','route_id'=>'3092','route'=>'/addons/bloc/bloclevel/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'sys-Company-level','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'947','name'=>'商户管理','parent'=>'997','route_id'=>'3095','route'=>'/addons/store/list/index','order'=>'1','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'sys-Merchant-Management','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'949','name'=>'商户标签','parent'=>'997','route_id'=>'3097','route'=>'/addons/store/storelabel/index','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'sys-Merchant-Label','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'993','name'=>'公司配置','parent'=>'222','route_id'=>'3094','route'=>'/addons/bloc/blocset/index','order'=>'3','data'=>NULL,'type'=>'sysai','level_type'=>'5','icon'=>'sys-Initial-Merchant','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'996','name'=>'公司管理','parent'=>'222','route_id'=>'3093','route'=>'/addons/bloc/list/index','order'=>'1','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'sys-Company-management','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'997','name'=>'商户管理','parent'=>'531','route_id'=>'3453','route'=>'/main/index.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'3','icon'=>'sys-Merchant-Management','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'998','name'=>'工作台','parent'=>'0','route_id'=>'3098','route'=>'/dashboard','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'1','icon'=>'sys-staging','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'999','name'=>'工作台','parent'=>'998','route_id'=>'3098','route'=>'/dashboard','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'sys-staging','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1018','name'=>'我的业务','parent'=>'254','route_id'=>'131','route'=>'/addons/addons/index','order'=>'0','data'=>NULL,'type'=>'sysai','level_type'=>'4','icon'=>'sys-my-business','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1024','name'=>'公司详情','parent'=>'996','route_id'=>'3450','route'=>'/addons/bloc/list/bloc-view.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1043','name'=>'组织架构','parent'=>'25','route_id'=>'3462','route'=>'/member/dd-member/member-organization.vue','order'=>'3','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'sys-organizational-structure','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1068','name'=>'系统配置','parent'=>'996','route_id'=>'3481','route'=>'/system/settings/index.vue','order'=>'1','data'=>NULL,'type'=>'','level_type'=>'6','icon'=>'el-dd-setting','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1098','name'=>'初始商户','parent'=>'997','route_id'=>'3517','route'=>'/addons/store/welcome/index.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'5','icon'=>'sys-Initial-Merchant','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1368','name'=>'更多业务','parent'=>'254','route_id'=>'4153','route'=>'/addons/addons/install.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'sys-More-business','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1381','name'=>'个人资料','parent'=>'28','route_id'=>'4164','route'=>'/profile/index.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1396','name'=>'关闭业务','parent'=>'254','route_id'=>'4171','route'=>'/addons/addons/uninstall.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'sys-Close-business','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1584','name'=>'设置','parent'=>'1583','route_id'=>'4321','route'=>'/setting/index.vue','order'=>'0','data'=>NULL,'type'=>'','level_type'=>'4','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1585','name'=>'更换管理员','parent'=>'1584','route_id'=>'4322','route'=>'/setting/administrator.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1586','name'=>'店铺认证','parent'=>'1584','route_id'=>'4323','route'=>'/setting/attestation/attestation.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1587','name'=>'店铺认证','parent'=>'1584','route_id'=>'4324','route'=>'/setting/attestation/storeattest.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1588','name'=>'账号设置','parent'=>'1584','route_id'=>'4328','route'=>'/system/account/index.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1612','name'=>'消息中心','parent'=>'1611','route_id'=>'4330','route'=>'/admin/message/index.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1613','name'=>'消息中心新建','parent'=>'1612','route_id'=>'4334','route'=>'/admin/message/create.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1614','name'=>'消息中心修改','parent'=>'1612','route_id'=>'4335','route'=>'/admin/message/update.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1615','name'=>'消息分类','parent'=>'1611','route_id'=>'4331','route'=>'/admin/messagecate/index.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'5','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'0']);
        $this->insert('{{%auth_menu}}',['id'=>'1616','name'=>'消息分类新建','parent'=>'1615','route_id'=>'4332','route'=>'/admin/messagecate/create.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'1617','name'=>'消息分类修改','parent'=>'1615','route_id'=>'4333','route'=>'/admin/messagecate/update.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>'','is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        $this->insert('{{%auth_menu}}',['id'=>'2874','name'=>'消息中心','parent'=>'28','route_id'=>'5133','route'=>'/system/notification/index.vue','order'=>'0','data'=>NULL,'type'=>NULL,'level_type'=>'6','icon'=>NULL,'is_sys'=>'system','module_name'=>'sys','is_show'=>'1']);
        
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

