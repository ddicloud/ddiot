<?php

use yii\db\Migration;

class m211229_023907_auth_assignment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%auth_assignment}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'item_id' => "int(11) NOT NULL",
            'item_name' => "varchar(64) NOT NULL",
            'user_id' => "varchar(64) NOT NULL",
            'created_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户与权限关系'");
        
        /* 索引设置 */
        $this->createIndex('auth_assignment_user_id_idx','{{%auth_assignment}}','user_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%auth_assignment}}',['id'=>'97','item_id'=>'45','item_name'=>'商户选择','user_id'=>'11','created_at'=>'1640709357']);
        $this->insert('{{%auth_assignment}}',['id'=>'98','item_id'=>'71','item_name'=>'权限规则','user_id'=>'11','created_at'=>'1640709711']);
        $this->insert('{{%auth_assignment}}',['id'=>'99','item_id'=>'70','item_name'=>'系统菜单','user_id'=>'11','created_at'=>'1640709897']);
        $this->insert('{{%auth_assignment}}',['id'=>'100','item_id'=>'72','item_name'=>'顶部导航','user_id'=>'11','created_at'=>'1640710030']);
        $this->insert('{{%auth_assignment}}',['id'=>'101','item_id'=>'63','item_name'=>'公司配置','user_id'=>'11','created_at'=>'1640710094']);
        $this->insert('{{%auth_assignment}}',['id'=>'111','item_id'=>'10','item_name'=>'模块统一入口','user_id'=>'11','created_at'=>'1640710607']);
        $this->insert('{{%auth_assignment}}',['id'=>'112','item_id'=>'8','item_name'=>'权限维护','user_id'=>'12','created_at'=>'1640710616']);
        $this->insert('{{%auth_assignment}}',['id'=>'115','item_id'=>'54','item_name'=>'系统配置','user_id'=>'12','created_at'=>'1640711114']);
        $this->insert('{{%auth_assignment}}',['id'=>'116','item_id'=>'19','item_name'=>'资源上传','user_id'=>'11','created_at'=>'1640711125']);
        $this->insert('{{%auth_assignment}}',['id'=>'117','item_id'=>'8','item_name'=>'权限维护','user_id'=>'11','created_at'=>'1640711230']);
        $this->insert('{{%auth_assignment}}',['id'=>'118','item_id'=>'54','item_name'=>'系统配置','user_id'=>'11','created_at'=>'1640711245']);
        $this->insert('{{%auth_assignment}}',['id'=>'119','item_id'=>'55','item_name'=>'会员管理','user_id'=>'11','created_at'=>'1640711300']);
        $this->insert('{{%auth_assignment}}',['id'=>'120','item_id'=>'59','item_name'=>'集团','user_id'=>'11','created_at'=>'1640711376']);
        $this->insert('{{%auth_assignment}}',['id'=>'121','item_id'=>'13','item_name'=>'站点管理','user_id'=>'11','created_at'=>'1640711385']);
        $this->insert('{{%auth_assignment}}',['id'=>'122','item_id'=>'13','item_name'=>'站点管理','user_id'=>'12','created_at'=>'1640739637']);
        $this->insert('{{%auth_assignment}}',['id'=>'124','item_id'=>'19','item_name'=>'资源上传','user_id'=>'12','created_at'=>'1640740322']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%auth_assignment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

