<?php

use yii\db\Migration;

class m230714_032924_user_upload_file extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_upload_file}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户id'",
            'file_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'store_id' => "int(11) NULL DEFAULT '0' COMMENT '商户id'",
            'from_type' => "varchar(255) NULL",
            'from_id' => "int(11) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        $this->createIndex('file_id','{{%user_upload_file}}','file_id',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_upload_file}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

