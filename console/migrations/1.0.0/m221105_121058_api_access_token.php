<?php

use yii\db\Migration;

class m221105_121058_api_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_access_token}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'refresh_token' => "varchar(60) NULL DEFAULT '' COMMENT '刷新令牌'",
            'access_token' => "varchar(60) NULL DEFAULT '' COMMENT '授权令牌'",
            'member_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '用户id'",
            'openid' => "varchar(50) NULL DEFAULT '' COMMENT '授权对象openid'",
            'group_id' => "varchar(100) NULL DEFAULT '' COMMENT '组别'",
            'bloc_id' => "int(11) NULL",
            'store_id' => "int(11) NULL",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'create_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_time' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'login_num' => "int(11) NULL DEFAULT '0' COMMENT '登录次数'",
            'allowance' => "int(11) NULL",
            'allowance_updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%api_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%api_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%api_access_token}}',['id'=>'406','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666692238','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666868315','member_id'=>'1','openid'=>'','group_id'=>'1','bloc_id'=>'8','store_id'=>'48','status'=>'1','create_time'=>'1666868315','updated_time'=>'0','login_num'=>'410','allowance'=>'56','allowance_updated_at'=>'1666868317']);
        $this->insert('{{%api_access_token}}',['id'=>'407','refresh_token'=>'UxXaACeqUQfkLFJbdt0wiTKqZULFW5Oi_1657683327','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658903920','member_id'=>'2','openid'=>'oJxlJ5WErfTqfRd7afF5nn4G2WS0','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658906813','updated_time'=>'0','login_num'=>'118','allowance'=>'57','allowance_updated_at'=>'1658909405']);
        $this->insert('{{%api_access_token}}',['id'=>'408','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657789225','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657789225','member_id'=>'3','openid'=>'oJxlJ5VjIDeUE95ayhQVJSXs-hA4','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1657789225','updated_time'=>'0','login_num'=>'1','allowance'=>'119','allowance_updated_at'=>'1657789335']);
        $this->insert('{{%api_access_token}}',['id'=>'409','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657789259','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1664527535','member_id'=>'4','openid'=>'oJxlJ5fsrN9xQ8J7mtcatD6b0CIU','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1664527535','updated_time'=>'0','login_num'=>'22','allowance'=>'119','allowance_updated_at'=>'1664527605']);
        $this->insert('{{%api_access_token}}',['id'=>'410','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657789737','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657789737','member_id'=>'5','openid'=>'oJxlJ5TZPypg11cwY1ncyvdGFjVQ','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1657791778','updated_time'=>'0','login_num'=>'2','allowance'=>'64','allowance_updated_at'=>'1657791784']);
        $this->insert('{{%api_access_token}}',['id'=>'411','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657792322','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657792322','member_id'=>'6','openid'=>'oJxlJ5XPpIqlnsIJWOAxg1ETA6oQ','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1657792322','updated_time'=>'0','login_num'=>'1','allowance'=>'119','allowance_updated_at'=>'1657792431']);
        $this->insert('{{%api_access_token}}',['id'=>'412','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657794063','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1657794063','member_id'=>'7','openid'=>'oJxlJ5eSyxZ4U2IJjcq-y1z2dBSY','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1657794063','updated_time'=>'0','login_num'=>'1','allowance'=>'119','allowance_updated_at'=>'1657794172']);
        $this->insert('{{%api_access_token}}',['id'=>'413','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658114124','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661912407','member_id'=>'8','openid'=>'oJxlJ5QY03m7o3OVvI1SD17L39Uk','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1661912407','updated_time'=>'0','login_num'=>'31','allowance'=>'113','allowance_updated_at'=>'1661913173']);
        $this->insert('{{%api_access_token}}',['id'=>'414','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658223314','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658487812','member_id'=>'9','openid'=>'oJxlJ5ZlXxsEnWOg78FBjv-UxGA8','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658487812','updated_time'=>'0','login_num'=>'3','allowance'=>'118','allowance_updated_at'=>'1658487920']);
        $this->insert('{{%api_access_token}}',['id'=>'415','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658224471','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658376071','member_id'=>'10','openid'=>'oJxlJ5RH2aAFQSA-EHY5rrBDQWjE','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658376072','updated_time'=>'0','login_num'=>'2','allowance'=>'58','allowance_updated_at'=>'1658376073']);
        $this->insert('{{%api_access_token}}',['id'=>'416','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658398856','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658398856','member_id'=>'11','openid'=>'oJxlJ5dR3CeY8ysk9XUmFYsOMi1Q','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658398856','updated_time'=>'0','login_num'=>'1','allowance'=>'70','allowance_updated_at'=>'1658398866']);
        $this->insert('{{%api_access_token}}',['id'=>'417','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658401704','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658401704','member_id'=>'12','openid'=>'oJxlJ5SaWvTgemnDBon9NtLO_8hQ','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658401703','updated_time'=>'0','login_num'=>'1','allowance'=>'63','allowance_updated_at'=>'1658401712']);
        $this->insert('{{%api_access_token}}',['id'=>'418','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658541500','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658541500','member_id'=>'13','openid'=>'oJxlJ5RIqnknlR8tTdlo5mJuI2OU','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658541500','updated_time'=>'0','login_num'=>'1','allowance'=>'88','allowance_updated_at'=>'1658541519']);
        $this->insert('{{%api_access_token}}',['id'=>'419','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658832672','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658832672','member_id'=>'14','openid'=>'oJxlJ5ZpqZtMjfrXPlKxqTVJxFjc','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658832672','updated_time'=>'0','login_num'=>'1','allowance'=>'118','allowance_updated_at'=>'1658832788']);
        $this->insert('{{%api_access_token}}',['id'=>'420','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1664156800','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1664156800','member_id'=>'15','openid'=>'oJxlJ5Ra8v5KXbH_o2-ak6foJkhE','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1664156800','updated_time'=>'0','login_num'=>'6','allowance'=>'117','allowance_updated_at'=>'1664156980']);
        $this->insert('{{%api_access_token}}',['id'=>'421','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658917536','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1658917536','member_id'=>'16','openid'=>'oJxlJ5bHa3nZ6inz3Y7SKt1jlRGU','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1658917536','updated_time'=>'0','login_num'=>'1','allowance'=>'118','allowance_updated_at'=>'1658917652']);
        $this->insert('{{%api_access_token}}',['id'=>'422','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659428584','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659428584','member_id'=>'17','openid'=>'oJxlJ5VcV_arzMrkQ8YndOR9Rq_s','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1659428584','updated_time'=>'0','login_num'=>'1','allowance'=>'59','allowance_updated_at'=>'1659428585']);
        $this->insert('{{%api_access_token}}',['id'=>'423','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659449182','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659449182','member_id'=>'18','openid'=>'oJxlJ5dtZWHHr5UAfIaSENM988X4','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1659449182','updated_time'=>'0','login_num'=>'1','allowance'=>'119','allowance_updated_at'=>'1659449233']);
        $this->insert('{{%api_access_token}}',['id'=>'424','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659753782','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659753782','member_id'=>'20','openid'=>'oJxlJ5Uv_JWAoGr41LWLJxpgta3I','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1659753782','updated_time'=>'0','login_num'=>'1','allowance'=>'57','allowance_updated_at'=>'1659753782']);
        $this->insert('{{%api_access_token}}',['id'=>'425','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659753992','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659753992','member_id'=>'21','openid'=>'oJxlJ5YamEUyhp7tHlJatl62sRS4','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1659753992','updated_time'=>'0','login_num'=>'1','allowance'=>'59','allowance_updated_at'=>'1659754083']);
        $this->insert('{{%api_access_token}}',['id'=>'426','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659925580','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1659925580','member_id'=>'22','openid'=>'oJxlJ5cOl62IrlG0UOMq56sLEEVw','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1659925580','updated_time'=>'0','login_num'=>'1','allowance'=>'96','allowance_updated_at'=>'1659925622']);
        $this->insert('{{%api_access_token}}',['id'=>'427','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1660116888','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661936588','member_id'=>'23','openid'=>'oJxlJ5RnDpV3sdbREvFt_207WmSY','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1661936588','updated_time'=>'0','login_num'=>'2','allowance'=>'91','allowance_updated_at'=>'1661936611']);
        $this->insert('{{%api_access_token}}',['id'=>'428','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661417517','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661417517','member_id'=>'24','openid'=>'oJxlJ5V9KiSCHInJd63tL5UWO9tc','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1661417537','updated_time'=>'0','login_num'=>'1','allowance'=>'59','allowance_updated_at'=>'1661417537']);
        $this->insert('{{%api_access_token}}',['id'=>'429','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661763228','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661763228','member_id'=>'25','openid'=>'oJxlJ5WFE2Ys18h59sk2zsoqohf4','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1661763228','updated_time'=>'0','login_num'=>'1','allowance'=>'118','allowance_updated_at'=>'1661763271']);
        $this->insert('{{%api_access_token}}',['id'=>'430','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661868500','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1661868500','member_id'=>'26','openid'=>'oJxlJ5RfFJ_mTiRzqr4AzLCX0E88','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1661868500','updated_time'=>'0','login_num'=>'1','allowance'=>'57','allowance_updated_at'=>'1661868500']);
        $this->insert('{{%api_access_token}}',['id'=>'431','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1662338567','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1662338567','member_id'=>'27','openid'=>'oJxlJ5UYxOeGjDSKF_bkPtpP4Ss4','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1662338567','updated_time'=>'0','login_num'=>'1','allowance'=>'83','allowance_updated_at'=>'1662338589']);
        $this->insert('{{%api_access_token}}',['id'=>'432','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1662546391','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1662546391','member_id'=>'28','openid'=>'oJxlJ5aN-9RpQCEGlUzr_7w4wxi8','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1662546391','updated_time'=>'0','login_num'=>'1','allowance'=>'72','allowance_updated_at'=>'1662546414']);
        $this->insert('{{%api_access_token}}',['id'=>'433','refresh_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666010829','access_token'=>'c4a760a8-dbcf-5254-a0d9-6a4474bd1b62_1666010829','member_id'=>'29','openid'=>'oJxlJ5e-Mo7ovxj2SY2NSxlZh1aI','group_id'=>'1','bloc_id'=>'13','store_id'=>'62','status'=>'1','create_time'=>'1666010829','updated_time'=>'0','login_num'=>'1','allowance'=>'114','allowance_updated_at'=>'1666010932']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

