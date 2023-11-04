<?php

use yii\db\Migration;

class m231104_123105_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%store}}', [
            'store_id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '商户id'",
            'category_id' => "int(11) NOT NULL",
            'category_pid' => "int(11) NOT NULL",
            'name' => "varchar(255) NULL COMMENT '门店名称'",
            'logo' => "varchar(255) NULL",
            'bloc_id' => "int(11) NULL COMMENT '关联公司'",
            'province' => "varchar(10) NULL COMMENT '省份'",
            'city' => "varchar(10) NULL COMMENT '城市'",
            'address' => "varchar(255) NULL COMMENT '详细地址'",
            'county' => "varchar(10) NULL COMMENT '区县'",
            'mobile' => "varchar(11) NULL COMMENT '联系电话'",
            'create_time' => "varchar(30) NULL",
            'update_time' => "varchar(30) NULL",
            'status' => "int(10) NULL DEFAULT '0' COMMENT '0:待审核,1:已通过,3:已拉黑'",
            'lng_lat' => "varchar(100) NULL COMMENT '经纬度'",
            'extra' => "text NULL COMMENT '商户扩展字段'",
            'longitude' => "varchar(255) NOT NULL",
            'latitude' => "varchar(255) NOT NULL",
            'PRIMARY KEY (`store_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store}}',['store_id'=>'153','category_id'=>'6','category_pid'=>'5','name'=>'茶室','logo'=>'202310/31/661a6c75-e651-3ade-a81c-58ae8cc75ba5.png','bloc_id'=>'91','province'=>'801','city'=>'802','address'=>'小营西路32号院','county'=>'813','mobile'=>'17778984690','create_time'=>'1687228915','update_time'=>'1698742512','status'=>'1','lng_lat'=>'{\"lng\":\"116.336531\",\"lat\":\"40.040015\"}','extra'=>'s:24:"s:16:"s:9:"s:2:"N;";";";";','longitude'=>'116.336531','latitude'=>'40.040015']);
        $this->insert('{{%store}}',['store_id'=>'163','category_id'=>'0','category_pid'=>'0','name'=>'酒店221','logo'=>'','bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>'','create_time'=>'1687230583','update_time'=>'1693533795','status'=>'0','lng_lat'=>'{\"lng\":\"\",\"lat\":\"\"}','extra'=>'s:2:"N;";','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'175','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687237426','update_time'=>'1687237426','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'176','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687237684','update_time'=>'1687237684','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'178','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687315366','update_time'=>'1687315366','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

