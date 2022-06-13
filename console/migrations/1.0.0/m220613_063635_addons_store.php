<?php

use yii\db\Migration;

class m220613_063635_addons_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%addons_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'type' => "smallint(6) NULL COMMENT '用户类型'",
            'module_name' => "varchar(50) NULL COMMENT '所属模块'",
            'store_id' => "int(11) NULL COMMENT '商户'",
            'bloc_id' => "int(11) NULL COMMENT '公司'",
            'status' => "smallint(6) NULL COMMENT '审核状态'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用商户权限'");
        
        /* 索引设置 */
        $this->createIndex('module_name','{{%addons_store}}','module_name',0);
        $this->createIndex('user_id','{{%addons_store}}','store_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%addons_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

