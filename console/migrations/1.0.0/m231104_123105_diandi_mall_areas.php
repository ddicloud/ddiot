<?php

use yii\db\Migration;

class m231104_123105_diandi_mall_areas extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_areas}}', [
            'area_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '区域id'",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'area_name' => "varchar(255) NOT NULL DEFAULT '' COMMENT '区域名称'",
            'create_time' => "int(11) NOT NULL COMMENT '创建时间'",
            'address' => "varchar(255) NULL COMMENT '具体地址'",
            'logo' => "varchar(255) NULL COMMENT '配送点标志'",
            'status' => "int(11) NULL DEFAULT '0' COMMENT '配送点状态'",
            'freight' => "decimal(10,0) NULL COMMENT '运费'",
            'province_id' => "int(11) NULL COMMENT '省份'",
            'is_default' => "int(11) NOT NULL DEFAULT '0'",
            'city_id' => "int(11) NULL COMMENT '城市'",
            'region_id' => "int(11) NULL COMMENT '区县'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`area_id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_areas}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

