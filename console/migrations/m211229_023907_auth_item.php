<?php

use yii\db\Migration;

class m211229_023907_auth_item extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_item}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(64) NOT NULL",
            'type' => "smallint(6) NOT NULL COMMENT '0系统1模块'",
            'description' => "text NULL",
            'rule_name' => "int(11) NULL DEFAULT '0'",
            'parent_id' => "int(11) NULL",
            'permission_type' => "int(11) NULL COMMENT '权限类型:0: 目录1: 页面 2: 按钮 3: 接口'",
            'data' => "blob NULL",
            'module_name' => "varchar(50) NULL",
            'created_at' => "int(11) NULL",
            'updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('rule_name','{{%auth_item}}','rule_name',0);
        $this->createIndex('type','{{%auth_item}}','type',0);
        $this->createIndex('name','{{%auth_item}}','name',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_item}}',['id'=>'6','name'=>'开发示例','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'66','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1585611530','updated_at'=>'1640700495']);
        $this->insert('{{%auth_item}}',['id'=>'8','name'=>'权限维护','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1582139364','updated_at'=>'1640700554']);
        $this->insert('{{%auth_item}}',['id'=>'10','name'=>'模块统一入口','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'65','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1588808930','updated_at'=>'1640700452']);
        $this->insert('{{%auth_item}}',['id'=>'13','name'=>'站点管理','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>NULL,'data'=>NULL,'module_name'=>'sys','created_at'=>'1582139575','updated_at'=>'1582139575']);
        $this->insert('{{%auth_item}}',['id'=>'15','name'=>'系统','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1582139568','updated_at'=>'1640699940']);
        $this->insert('{{%auth_item}}',['id'=>'19','name'=>'资源上传','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'65','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1585451956','updated_at'=>'1640700441']);
        $this->insert('{{%auth_item}}',['id'=>'29','name'=>'数据库','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'15','permission_type'=>NULL,'data'=>NULL,'module_name'=>'sys','created_at'=>'1592915692','updated_at'=>'1592915723']);
        $this->insert('{{%auth_item}}',['id'=>'45','name'=>'商户选择','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'65','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1614077853','updated_at'=>'1640700810']);
        $this->insert('{{%auth_item}}',['id'=>'54','name'=>'系统配置','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'15','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1635403574','updated_at'=>'1640699930']);
        $this->insert('{{%auth_item}}',['id'=>'55','name'=>'会员管理','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640699224','updated_at'=>'1640699224']);
        $this->insert('{{%auth_item}}',['id'=>'56','name'=>'会员管理','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'55','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640699244','updated_at'=>'1640699244']);
        $this->insert('{{%auth_item}}',['id'=>'57','name'=>'会员组','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'55','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640699401','updated_at'=>'1640699401']);
        $this->insert('{{%auth_item}}',['id'=>'58','name'=>'组织架构','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'55','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640699419','updated_at'=>'1640699419']);
        $this->insert('{{%auth_item}}',['id'=>'59','name'=>'集团','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700313','updated_at'=>'1640700313']);
        $this->insert('{{%auth_item}}',['id'=>'60','name'=>'商户','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'59','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700323','updated_at'=>'1640700323']);
        $this->insert('{{%auth_item}}',['id'=>'61','name'=>'公司','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'59','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700336','updated_at'=>'1640700336']);
        $this->insert('{{%auth_item}}',['id'=>'62','name'=>'公司等级','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'61','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700358','updated_at'=>'1640700358']);
        $this->insert('{{%auth_item}}',['id'=>'63','name'=>'公司配置','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'61','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700380','updated_at'=>'1640700380']);
        $this->insert('{{%auth_item}}',['id'=>'64','name'=>'公司信息维护','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'61','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700395','updated_at'=>'1640700395']);
        $this->insert('{{%auth_item}}',['id'=>'65','name'=>'公共权限','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700426','updated_at'=>'1640700426']);
        $this->insert('{{%auth_item}}',['id'=>'66','name'=>'代码生成','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700483','updated_at'=>'1640700483']);
        $this->insert('{{%auth_item}}',['id'=>'67','name'=>'权限','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'0','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700519','updated_at'=>'1640700534']);
        $this->insert('{{%auth_item}}',['id'=>'68','name'=>'菜单路由','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700567','updated_at'=>'1640700567']);
        $this->insert('{{%auth_item}}',['id'=>'69','name'=>'权限分配','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'1','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700577','updated_at'=>'1640700577']);
        $this->insert('{{%auth_item}}',['id'=>'70','name'=>'系统菜单','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700586','updated_at'=>'1640700586']);
        $this->insert('{{%auth_item}}',['id'=>'71','name'=>'权限规则','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700598','updated_at'=>'1640700598']);
        $this->insert('{{%auth_item}}',['id'=>'72','name'=>'顶部导航','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'15','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700617','updated_at'=>'1640700617']);
        $this->insert('{{%auth_item}}',['id'=>'73','name'=>'管理员','type'=>'0','description'=>NULL,'rule_name'=>NULL,'parent_id'=>'67','permission_type'=>'0','data'=>NULL,'module_name'=>'sys','created_at'=>'1640700744','updated_at'=>'1640700744']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_item}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

