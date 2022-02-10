<?php

use yii\db\Migration;

class m211229_023907_store extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store}}',['store_id'=>'61','category_id'=>'16','category_pid'=>'5','name'=>'客服小店','logo'=>'202012/14/f42fc67e-b09d-3b8c-9969-279311b91019.jpg','bloc_id'=>'8','province'=>'2898','city'=>'2899','address'=>'陕西省西安市雁塔区永松路116A名人居','county'=>'2905','mobile'=>'','create_time'=>NULL,'update_time'=>NULL,'status'=>'1','lng_lat'=>'{\\\"lng\\\":\\\"108.93104\\\",\\\"lat\\\":\\\"34.235521\\\"}','extra'=>'a:23:{s:5:"intro";s:0:"";s:7:"service";s:0:"";s:9:"hotSearch";s:0:"";s:6:"notice";s:0:"";s:3:"des";s:0:"";s:12:"surroundings";s:0:"";s:11:"certificate";s:0:"";s:12:"contact_type";s:0:"";s:9:"send_type";a:1:{i:0;s:1:"0";}s:8:"distance";s:0:"";s:13:"startingPrice";s:0:"";s:12:"shippingDees";s:0:"";s:8:"Lodop_ip";s:0:"";s:4:"USER";s:0:"";s:4:"UKEY";s:0:"";s:2:"SN";s:0:"";s:8:"printNum";s:0:"";s:8:"douradio";s:3:"0.4";s:10:"moneyradio";s:3:"0.4";s:8:"agemoney";s:0:"";s:8:"shareimg";s:0:"";s:10:"myshareimg";s:0:"";s:7:"onecode";s:0:"";}','longitude'=>'108.93104','latitude'=>'34.235521']);
        $this->insert('{{%store}}',['store_id'=>'75','category_id'=>'5','category_pid'=>'6','name'=>'和生官网','logo'=>'https://dev.hopesfire.com/attachment/202109/23/4b424c23-eb99-3bec-a473-d260d7b21675.png','bloc_id'=>'27','province'=>'801','city'=>'802','address'=>'23','county'=>'813','mobile'=>'34','create_time'=>'1632363856','update_time'=>'1632363856','status'=>'1','lng_lat'=>'{\\\"lng\\\":\\\"116.43006\\\",\\\"lat\\\":\\\"39.886568\\\"}','extra'=>'N;','longitude'=>'116.43006','latitude'=>'39.886568']);
        $this->insert('{{%store}}',['store_id'=>'77','category_id'=>'5','category_pid'=>'6','name'=>'荣誉墙','logo'=>'https://dev.hopesfire.com/attachment/202111/12/7ca2bcff-e75b-3ab0-bffb-c9a0c357ac8e.png','bloc_id'=>'28','province'=>'2367','city'=>'2440','address'=>'','county'=>'2442','mobile'=>'1223324324','create_time'=>'1636711455','update_time'=>'1636711455','status'=>'1','lng_lat'=>'{\\\"lng\\\":\\\"116.334049\\\",\\\"lat\\\":\\\"39.979958\\\"}','extra'=>'N;','longitude'=>'116.334049','latitude'=>'39.979958']);
        
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

