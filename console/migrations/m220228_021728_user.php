<?php

use yii\db\Migration;

class m220228_021728_user extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%user}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'mobile' => "varchar(11) NULL COMMENT '手机号'",
            'company' => "varchar(100) NULL COMMENT '公司名称'",
            'username' => "varchar(255) NOT NULL",
            'auth_key' => "varchar(32) NOT NULL",
            'password_hash' => "varchar(255) NOT NULL",
            'password_reset_token' => "varchar(255) NULL",
            'email' => "varchar(255) NOT NULL",
            'store_id' => "int(11) NULL DEFAULT '0'",
            'bloc_id' => "int(11) NULL DEFAULT '0'",
            'status' => "smallint(6) NOT NULL DEFAULT '10'",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'verification_token' => "varchar(255) NULL",
            'last_time' => "int(11) NULL",
            'avatar' => "varchar(255) NULL",
            'is_login' => "int(11) NULL DEFAULT '0'",
            'last_login_ip' => "varchar(50) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('username','{{%user}}','username',1);
        $this->createIndex('email','{{%user}}','email',1);
        $this->createIndex('password_reset_token','{{%user}}','password_reset_token',1);
        
        
        /* 表数据 */
        $this->insert('{{%user}}',['id'=>'1','mobile'=>NULL,'company'=>NULL,'username'=>'2192138785@qq.com','auth_key'=>'NGUmVtGWb0UcEbCpJRBGi9sNGlxFDh2A','password_hash'=>'$2y$13$sXkOACTm6G3pcN04U5GmKu1ubNjyNJI.V/Dq9dqMjR0zP56bmZFLi','password_reset_token'=>'s1dWPeGXXQ_qIox_Yl2k15-8e44CjqMm_1642788779','email'=>'2192138785@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1576871151','updated_at'=>'1624589927','verification_token'=>'MZNKkOQL1eDMOgEUeb9HP7RFiU57r7EO_1576871151','last_time'=>'1642788779','avatar'=>'202106/25/6aba7385-103c-37a2-a0c1-9e2f24931918.png','is_login'=>'1','last_login_ip'=>'219.145.5.81']);
        $this->insert('{{%user}}',['id'=>'9','mobile'=>NULL,'company'=>NULL,'username'=>'1065461385@qq.com','auth_key'=>'FUht96Sul95N8TFYKY8X0EHinZwlvUtJ','password_hash'=>'$2y$13$59z2ild711NIbyBCa4d3JObTqRVKbTN5ZfJc4qFQEQ0xIq6.DLdd6','password_reset_token'=>'nWtkDL0XP-Fkh70UL-BS3LgFdu_bQNNC_1586862613','email'=>'1065461385@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1582347562','updated_at'=>'1586862613','verification_token'=>'FQfBgfi_eNi4TYRrjMH553TdENmIrTvp_1582347562','last_time'=>NULL,'avatar'=>'202002/22/d4639524-f5ef-3a2f-9ee6-914a1d8049b7.png','is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'10','mobile'=>NULL,'company'=>NULL,'username'=>'ceshi','auth_key'=>'wYDEiXVZl-_njSqJQGO_zlErztscMFVW','password_hash'=>'$2y$13$9V1VXn0Gy.k84PfHDkFezOxbMsEIHhwtLYRKTjnCuATB.gv/XBCcu','password_reset_token'=>'B0tInjCYGt56HA1HpgfGKjiufL3nK6ru_1631591574','email'=>'123@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1586670383','updated_at'=>'1586670383','verification_token'=>NULL,'last_time'=>'1631591574','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'222.90.93.91']);
        $this->insert('{{%user}}',['id'=>'11','mobile'=>'17778984690','company'=>'途火科技','username'=>'admin','auth_key'=>'ddkNMK6gRRPa82aYfvTfzmQ0xYHyZT-i','password_hash'=>'$2y$13$W4yYZPf2it..e6qRUXtnGOmSt97fAWsjQCQE9aEDzoBV8BLTXviG.','password_reset_token'=>'-311VrAjlx_gQPij5xCvyoDIX0sDYPQ6_1645862685','email'=>'admin@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1586678074','updated_at'=>'1641697493','verification_token'=>NULL,'last_time'=>'1645862685','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>'222.90.93.237']);
        $this->insert('{{%user}}',['id'=>'12','mobile'=>NULL,'company'=>NULL,'username'=>'dfg','auth_key'=>'-q8yp_xLpRpQHnXrtci6OiwU113VrUWr','password_hash'=>'$2y$13$yMCDqPfbNc15HdAOSB7EH.g3AikIM4zT8R/Z3.oS4ck9JnRS6AIaK','password_reset_token'=>NULL,'email'=>'ss@q.com','store_id'=>'51','bloc_id'=>'8','status'=>'1','created_at'=>'1586935807','updated_at'=>'1586935807','verification_token'=>'F2v8oKETuclP7zej-9UZn4MRDWv80G6J_1586935807','last_time'=>NULL,'avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'13','mobile'=>NULL,'company'=>NULL,'username'=>'diandi','auth_key'=>'v8bGsV07bn4TF4nvfT5JiYh6Xovk2TM9','password_hash'=>'$2y$13$lp29ChORcnGU6/KBkW6I/.FmdfE8HeIeoy1chNsLH3ZYJdoYvG8Tm','password_reset_token'=>'9gRPMUg9s9_PCIXw-UbsYrAOcgzy7XO7_1587521075','email'=>'diandi@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1587189038','updated_at'=>'1587189107','verification_token'=>NULL,'last_time'=>'1587521075','avatar'=>'202004/18/d8295118-6da2-30ce-ace2-311d6d1f4bea.jpg','is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'14','mobile'=>NULL,'company'=>NULL,'username'=>'order','auth_key'=>'OOAkfNC58qLFiZ76FtD__rPlPXHXU3tZ','password_hash'=>'$2y$13$AKfeDL9UR3L8fZ4lkwVJCOduYsVn/UBH/4OOr1wQr4MXkxOqeQnkS','password_reset_token'=>'US1xaHkZaPhTKnnTmayIx8bq-J3fZbP6_1596267977','email'=>'order@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1587788493','updated_at'=>'1587788493','verification_token'=>NULL,'last_time'=>'1596267977','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'15','mobile'=>NULL,'company'=>NULL,'username'=>'order1','auth_key'=>'1p8L0npWi7ZOqpAMzVrmoKjVLNaECARU','password_hash'=>'$2y$13$sREbTSc9B1HkK6mH2Fw9xOpruT8rn4vzHyGZ2vNZN7fjNqc00hM5K','password_reset_token'=>'DblmKqQLvsv3-TV38WmBenfrcGc27PuS_1593221556','email'=>'123@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1587788715','updated_at'=>'1587788715','verification_token'=>NULL,'last_time'=>'1593221556','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'16','mobile'=>NULL,'company'=>NULL,'username'=>'ninini','auth_key'=>'EnlngA6I8EYiCDuCDQa9CgDyYuJcvvpi','password_hash'=>'$2y$13$jQRkfZ/0ox.Qz8pGaC4vfezVSDamjsk12UJpa5Cur5MtuPdlsd8Hm','password_reset_token'=>'dGc5NDKGGd5yCQCM9s3_SRYGsxhgWUM3_1614084241','email'=>'132@qq.com','store_id'=>'28','bloc_id'=>'1','status'=>'1','created_at'=>'1589842427','updated_at'=>'1589843314','verification_token'=>NULL,'last_time'=>'1614084241','avatar'=>'202005/19/3dfb19aa-56c5-3036-a6f7-b2e187c89aa3.jpg','is_login'=>'1','last_login_ip'=>'127.0.0.1']);
        $this->insert('{{%user}}',['id'=>'17','mobile'=>NULL,'company'=>NULL,'username'=>'hhhh','auth_key'=>'MK7mTWkeb0JwB9bUA6siWhh706fP6Wxy','password_hash'=>'$2y$13$i0.S7tX6h94KQBQ7tLSmOu8OHya.vsLOxGBjh7Kn2nophtFEGOFWy','password_reset_token'=>NULL,'email'=>'3232@163.com','store_id'=>'51','bloc_id'=>'8','status'=>'1','created_at'=>'1589842601','updated_at'=>'1614084223','verification_token'=>NULL,'last_time'=>NULL,'avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'18','mobile'=>NULL,'company'=>NULL,'username'=>'ccc123','auth_key'=>'9AYOEXKgF-yVniPmfm8_UAK3cKbtSWRq','password_hash'=>'$2y$13$Bd5cQuAfp8eQTPg4IlT0E.JtD04WFBK1y.Rto3oGOBTUEc4BGbLZG','password_reset_token'=>NULL,'email'=>'ccc123@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1590278995','updated_at'=>'1590278995','verification_token'=>NULL,'last_time'=>NULL,'avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'19','mobile'=>NULL,'company'=>NULL,'username'=>'aaa123','auth_key'=>'k-rL5FNOlwPqCY2HXVoqCfQTl03dr6K3','password_hash'=>'$2y$13$mJBi5/.9LUW6smQBBv/mIua0x6B/BTZyxHLbXduD1WRipadxxCZqa','password_reset_token'=>NULL,'email'=>'aaa123@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1590279043','updated_at'=>'1590279043','verification_token'=>NULL,'last_time'=>NULL,'avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'20','mobile'=>NULL,'company'=>NULL,'username'=>'changquan','auth_key'=>'IK15dMg0szhJhppVbpTW6ue5tcT2XiKp','password_hash'=>'$2y$13$TTOA5ntybN3u7Z8NslDT8egnZLScDHU5tO6T03/IaVii7j8Tygm3u','password_reset_token'=>'xEFnzHfg1CdkBlZpqX6aEYbbe9G4PTxV_1597116547','email'=>'changquan@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1593569260','updated_at'=>'1593569260','verification_token'=>NULL,'last_time'=>'1597116547','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'21','mobile'=>NULL,'company'=>NULL,'username'=>'choujiang','auth_key'=>'b7G1jnW2Oxdj2Djnw3ClaMJAYDl_ttFh','password_hash'=>'$2y$13$iK84d4e9pDNKxHi7bbnbH.K3kL47/Qt60njkOohiultRBHR6ojdIO','password_reset_token'=>'GLzYB6wrIKhPGhy3zbfz5Rb4L64hCw7D_1593923853','email'=>'12345678@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1593679620','updated_at'=>'1593679620','verification_token'=>NULL,'last_time'=>'1593923853','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'22','mobile'=>NULL,'company'=>NULL,'username'=>'shanghu001','auth_key'=>'m_N_TvGt6Yrtxch1YovK2wo1DZy4KJ0Y','password_hash'=>'$2y$13$FAu3O1/IIEZwBMCqc4p1e.OvLKrIEuW.yLallPIYqrIBRLXqn6nMK','password_reset_token'=>'A4OEsEHYuv0wsEoxqZjFtNBOgEtX9pxj_1607683158','email'=>'shanghu001@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1607682744','updated_at'=>'1607682744','verification_token'=>NULL,'last_time'=>'1607683158','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>NULL]);
        $this->insert('{{%user}}',['id'=>'23','mobile'=>NULL,'company'=>NULL,'username'=>'ceshi111','auth_key'=>'9hr92n5FKM9qlZdb9gmzEcBUjlKNiT-Y','password_hash'=>'$2y$13$7rIoKBgzQBdVjwdHhAXkJezHpFJPy1uXs0SrXFoV48jbH1THRR/Ca','password_reset_token'=>'Z84F9dd-VECWn3kNoTirr8iyrVP4oIYk_1626517428','email'=>'ceshi@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1616639318','updated_at'=>'1616639318','verification_token'=>NULL,'last_time'=>'1626517428','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>'127.0.0.1']);
        $this->insert('{{%user}}',['id'=>'29','mobile'=>NULL,'company'=>NULL,'username'=>'chunchun','auth_key'=>'V-BnomKFax1QdpQBvy68gWF5ZeO_qNA8','password_hash'=>'$2y$13$SBpDCfKYIUUTmCv0QO9sQOknkPTQfl9X5sV40VIZrssQg1MoM9sn2','password_reset_token'=>'PgKznEazdx-3UTgLk0cmf1zhAOAINAgO_1644224432','email'=>'chunchun@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1626524235','updated_at'=>'1626524235','verification_token'=>NULL,'last_time'=>'1644224432','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'222.90.95.22']);
        $this->insert('{{%user}}',['id'=>'30','mobile'=>NULL,'company'=>NULL,'username'=>'chunchuna','auth_key'=>'DVedLlurY6QPEI4iAVSLgkGJx7ILQ9dh','password_hash'=>'$2y$13$rRB1PeEjJcrDRn3zy65LHO2eW9JMPAAhyCzv.zliWfq5bEQfmmgXi','password_reset_token'=>'-Ux7-XQVPzzDP4guNHL2f1X7hFP9XqFb_1626525298','email'=>'chunchuna@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1626525266','updated_at'=>'1626525266','verification_token'=>NULL,'last_time'=>'1626525298','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>'127.0.0.1']);
        $this->insert('{{%user}}',['id'=>'31','mobile'=>NULL,'company'=>NULL,'username'=>'hesheng','auth_key'=>'Qj6DxTwAB-44IWad9po3SHDtYpAv0OQ7','password_hash'=>'$2y$13$Qa8G6EOQGzY3XdibikKtb.UfAgdYXb4o9qA243uEL7wDrHkU504vO','password_reset_token'=>'-9gGHE9n5rLXEC0dR9pQaTuhOwEtMJ6A_1632978479','email'=>'hesheng@163.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1632977936','updated_at'=>'1632977936','verification_token'=>NULL,'last_time'=>'1632978479','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'123.139.24.198']);
        $this->insert('{{%user}}',['id'=>'32','mobile'=>NULL,'company'=>NULL,'username'=>'rongyu','auth_key'=>'DAJLBbch7XubdNijLp-D06-OB2p63-HN','password_hash'=>'$2y$13$zZiWEJ9h4jVtzFQwm.hHu.RrLdeCEsIUrF/3sYRoId8VfwISt/HTK','password_reset_token'=>'Ar8fKfkkBgxKubXGoE4HSq3uoZM4F5UY_1645239092','email'=>'1213@qq.com','store_id'=>NULL,'bloc_id'=>NULL,'status'=>'1','created_at'=>'1636555751','updated_at'=>'1636556257','verification_token'=>NULL,'last_time'=>'1645239092','avatar'=>NULL,'is_login'=>'0','last_login_ip'=>'222.90.95.86']);
        $this->insert('{{%user}}',['id'=>'33','mobile'=>NULL,'company'=>NULL,'username'=>'dangjian','auth_key'=>'SZKQzRhs3goHbRs776Cgh3on1kRl2cSk','password_hash'=>'$2y$13$lhqBQawaGprINP7NZ3wHneyDRS/skOf6JzxwzIrTEDmC8lmpenj1i','password_reset_token'=>'yv5DzZBw98ZQIkCl7ZpMWWm8GHabYPxE_1644569908','email'=>'12322@qq.com','store_id'=>'0','bloc_id'=>'0','status'=>'1','created_at'=>'1644500862','updated_at'=>'1644500862','verification_token'=>NULL,'last_time'=>'1644569908','avatar'=>NULL,'is_login'=>'1','last_login_ip'=>'222.90.95.206']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%user}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

