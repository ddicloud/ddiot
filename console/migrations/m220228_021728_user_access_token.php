<?php

use yii\db\Migration;

class m220228_021728_user_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user_access_token}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'refresh_token' => "varchar(60) NULL DEFAULT '' COMMENT '刷新令牌'",
            'access_token' => "varchar(60) NULL DEFAULT '' COMMENT '授权令牌'",
            'user_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '用户id'",
            'openid' => "varchar(50) NULL DEFAULT '' COMMENT '授权对象openid'",
            'group_id' => "varchar(100) NULL DEFAULT '' COMMENT '组别'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'create_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'allowance' => "int(11) NULL",
            'allowance_updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%user_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%user_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%user_access_token}}',['id'=>'1','refresh_token'=>'Wab92NsDDcE7g2XfZsBT9g8ZL2yHx6cv_1642788778','access_token'=>'h6col_ADX4Jsu-kjGWY4_22yYabMFbgc_1642788778','user_id'=>'1','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1642788778','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'11','refresh_token'=>'9GCayoa2aSil8xHW7GirWMqplo-VH4id_1645862683','access_token'=>'vzN37DAv_TLiU0ZAhLtRK8z5GIFJJWbL_1645862683','user_id'=>'11','openid'=>'','group_id'=>'1','bloc_id'=>'27','store_id'=>'75','status'=>'1','create_time'=>'1645862683','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'29','refresh_token'=>'IeeEBH3Mb0CTI1CK5oP8aBI3fJ_9iTdg_1644224395','access_token'=>'WessDrVf2MP6EETVU-b__Hv_Z2Ao2T3U_1644224395','user_id'=>'29','openid'=>'','group_id'=>'1','bloc_id'=>'28','store_id'=>'77','status'=>'1','create_time'=>'1644224395','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'32','refresh_token'=>'N6xbHDPHEO4jY-lYToYVU-jqUtVg-xQR_1645238388','access_token'=>'NnaBb1qnz3qIP8R2UgpPQ8D2tnTQd-FX_1645238388','user_id'=>'32','openid'=>'','group_id'=>'1','bloc_id'=>'28','store_id'=>'77','status'=>'1','create_time'=>'1645238388','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'33','refresh_token'=>'lu9Tc6skwkGiWXcI7_MSulCnte9KvByR_1644569907','access_token'=>'YXFTgaFBum85TijHAlxDhy8bHP3huVGv_1644569907','user_id'=>'33','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1644569907','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'800','refresh_token'=>'Bua8WlSbT3J1boze7wqGYfY28W8hmLUq_1619031166','access_token'=>'swIxwykq4fqRj29gfZclKaEhdkZoXis4_1619031166','user_id'=>'26','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1619031166','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'801','refresh_token'=>'vdzCboReO1kJgkrG19YVS218M84owLDc_1619031699','access_token'=>'PlNQW1IWDOJAYKJwAvj1jSoQk9GSy2_I_1619031699','user_id'=>'28','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1619031699','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'804','refresh_token'=>'yf9yGks8hpidqSNZAoKlgsoJ5DQt7snT_1631591573','access_token'=>'-b9wJh4qoGXKoRTbLa5Ja22d7-ng5UmI_1631591573','user_id'=>'10','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1631591573','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        $this->insert('{{%user_access_token}}',['id'=>'805','refresh_token'=>'_4xa_hvTNKHWF52xW_Ec82Q1wkvSqUBh_1632978316','access_token'=>'5nGtMprhj4kC21ymmbdutdaVRJPke7sw_1632978316','user_id'=>'31','openid'=>'','group_id'=>'1','bloc_id'=>'0','store_id'=>'0','status'=>'1','create_time'=>'1632978316','updated_time'=>'0','allowance'=>NULL,'allowance_updated_at'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

