<?php

use yii\db\Migration;

class m230714_032924_store extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store}}',['store_id'=>'153','category_id'=>'6','category_pid'=>'5','name'=>'酒店1','logo'=>'202306/20/f7462438-7a19-30f3-af00-0ebdbda97007.jpg','bloc_id'=>'91','province'=>'801','city'=>'802','address'=>'小营西路32号院','county'=>'813','mobile'=>'17778984690','create_time'=>'1687228915','update_time'=>'1687236666','status'=>'1','lng_lat'=>'{\"lng\":\"116.336531\",\"lat\":\"40.040015\"}','extra'=>'s:2:"N;";','longitude'=>'116.336531','latitude'=>'40.040015']);
        $this->insert('{{%store}}',['store_id'=>'163','category_id'=>'0','category_pid'=>'0','name'=>'1','logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687230583','update_time'=>'1687230583','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'174','category_id'=>'0','category_pid'=>'0','name'=>'2号','logo'=>'','bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>'','create_time'=>'1687231458','update_time'=>'1687232090','status'=>'0','lng_lat'=>'{\"lng\":\"\",\"lat\":\"\"}','extra'=>'s:2:"N;";','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'175','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687237426','update_time'=>'1687237426','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'176','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687237684','update_time'=>'1687237684','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'177','category_id'=>'0','category_pid'=>'0','name'=>'A楼','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687309681','update_time'=>'1687309681','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'178','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'38','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687315366','update_time'=>'1687315366','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'179','category_id'=>'0','category_pid'=>'0','name'=>'test','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687327840','update_time'=>'1687327840','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'180','category_id'=>'0','category_pid'=>'0','name'=>'test_007','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687328050','update_time'=>'1687328050','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'181','category_id'=>'0','category_pid'=>'0','name'=>'test1','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687328434','update_time'=>'1687328434','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'182','category_id'=>'0','category_pid'=>'0','name'=>'test2','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687328504','update_time'=>'1687328504','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'183','category_id'=>'0','category_pid'=>'0','name'=>'hhh','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687328573','update_time'=>'1687328573','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'184','category_id'=>'0','category_pid'=>'0','name'=>'酒店首先测试','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687683539','update_time'=>'1687683539','status'=>'1','lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'185','category_id'=>'0','category_pid'=>'0','name'=>'13','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829216','update_time'=>'1687829216','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'186','category_id'=>'0','category_pid'=>'0','name'=>'test','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829228','update_time'=>'1687829228','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'187','category_id'=>'0','category_pid'=>'0','name'=>'嘿嘿嘿','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829419','update_time'=>'1687829419','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'188','category_id'=>'0','category_pid'=>'0','name'=>'还好还好','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829429','update_time'=>'1687829429','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'189','category_id'=>'0','category_pid'=>'0','name'=>'213','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829594','update_time'=>'1687829594','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'190','category_id'=>'0','category_pid'=>'0','name'=>'6','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829893','update_time'=>'1687829893','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'191','category_id'=>'0','category_pid'=>'0','name'=>'测试','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687829921','update_time'=>'1687829921','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'192','category_id'=>'0','category_pid'=>'0','name'=>'办公室','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687830179','update_time'=>'1687830179','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'193','category_id'=>'0','category_pid'=>'0','name'=>NULL,'logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687830569','update_time'=>'1687830710','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'s:2:"N;";','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'194','category_id'=>'0','category_pid'=>'0','name'=>'民宿','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687830615','update_time'=>'1687830615','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'195','category_id'=>'0','category_pid'=>'0','name'=>'阿尔法狗','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687830890','update_time'=>'1687857398','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'s:9:"s:2:"N;";";','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'196','category_id'=>'0','category_pid'=>'0','name'=>'A','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687833593','update_time'=>'1687833593','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'197','category_id'=>'0','category_pid'=>'0','name'=>'A','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687836282','update_time'=>'1687836282','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'198','category_id'=>'0','category_pid'=>'0','name'=>'B','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687836323','update_time'=>'1687836323','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'199','category_id'=>'0','category_pid'=>'0','name'=>'C','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687837627','update_time'=>'1687837627','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'200','category_id'=>'0','category_pid'=>'0','name'=>'D','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687837636','update_time'=>'1687837636','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'201','category_id'=>'0','category_pid'=>'0','name'=>'Aa','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687844551','update_time'=>'1687844551','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'202','category_id'=>'0','category_pid'=>'0','name'=>'测','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'123','county'=>'0','mobile'=>NULL,'create_time'=>'1687844574','update_time'=>'1687856510','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'s:24:"s:16:"s:9:"s:2:"N;";";";";','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'203','category_id'=>'0','category_pid'=>'0','name'=>'C','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687853754','update_time'=>'1687853754','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'204','category_id'=>'0','category_pid'=>'0','name'=>'a','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687855019','update_time'=>'1687855019','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'205','category_id'=>'0','category_pid'=>'0','name'=>'贝塔','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687857761','update_time'=>'1687857761','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        $this->insert('{{%store}}',['store_id'=>'206','category_id'=>'0','category_pid'=>'0','name'=>'欧米伽','logo'=>NULL,'bloc_id'=>'91','province'=>'0','city'=>'0','address'=>'','county'=>'0','mobile'=>NULL,'create_time'=>'1687935716','update_time'=>'1687935716','status'=>NULL,'lng_lat'=>'{\"lng\":null,\"lat\":null}','extra'=>'N;','longitude'=>'','latitude'=>'']);
        
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

