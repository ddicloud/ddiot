<?php

use yii\db\Migration;

class m220801_020131_diandi_website_contact extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_contact}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(255) NULL COMMENT '公司名称'",
            'mobile' => "varchar(15) NULL COMMENT '联系电话'",
            'phone' => "varchar(15) NULL COMMENT '座机号码'",
            'email' => "varchar(50) NULL COMMENT '邮箱'",
            'address' => "varchar(255) NULL COMMENT '具体地址'",
            'intro' => "text NULL COMMENT '简介'",
            'logo' => "varchar(255) NULL COMMENT '公司logo'",
            'wechat_code' => "varchar(255) NULL COMMENT '公众号二维码'",
            'image' => "varchar(255) NULL COMMENT '配图'",
            'fax' => "varchar(255) NULL COMMENT '传真'",
            'postcode' => "varchar(255) NULL",
            'icp' => "varchar(255) NULL",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'createtime' => "varchar(30) NULL",
            'updatetime' => "varchar(30) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='幻灯片'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_contact}}',['id'=>'1','name'=>'陕西和生科技有限公司','mobile'=>'029-63364356','phone'=>'029-63364356','email'=>'3443@qq.com','address'=>'西安市南二环西段财富中心二期D座1206室','intro'=>'<p>	陕西和生科技有限公司是陕西IT系统集成行业的优秀公司之一，公司拥有中国电子工业标准化技术协会颁发的信息技术服务运行维护贰级证书、信息系统集成及服务贰级资质、公安部安全技术防范壹级资质、电子与智能化工程专业承包贰级证书；通过了ISO9001质量管理体系认证、27001信息安全管理体系认证；获得了陕西省住房和城乡建设厅颁发的安全生产许可证证书、同时获得了由陕西省国家保密局颁发的涉密信息系统集成乙级资质证书。公司的业务领域涵盖：弱电工程、网络系统集成、网络安全及管理、高性能服务器集群系统、海量数据存储、企业数据（安全）管理、软件定制开发、IT信息技术服务及运维等。</p>','logo'=>'https://dev.hopesfire.com/attachment/202109/29/f44d6f37-e4bd-3830-9046-3fda0c819a01.png','wechat_code'=>'https://dev.hopesfire.com/attachment/202109/24/c1857b4e-580c-3bc1-a019-beec22917ff8.jpg','image'=>'https://dev.hopesfire.com/attachment/202109/30/9f20533d-2733-3122-b2b1-3973f3080ed3.jpg','fax'=>'029-63364359','postcode'=>'721000','icp'=>'陕icp备-5222256','store_id'=>'75','bloc_id'=>'27','createtime'=>'','updatetime'=>'']);
        $this->insert('{{%diandi_website_contact}}',['id'=>'3','name'=>'西安店滴云网络科技有限公司','mobile'=>'17349064684','phone'=>'17349064684','email'=>'2192138785@qq.com','address'=>'高新区科技二路','intro'=>'<p><span style=\"color: rgb(96, 98, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, Arial, sans-serif; font-size: 14px; font-weight: 700; text-align: right; background-color: rgb(255, 255, 255);\">公司简介</span></p>','logo'=>'202207/11/d74df280-ae3f-3655-90ad-54b4502eb85f.png','wechat_code'=>'202207/11/f18fa938-023b-39fd-8564-451cd845bc7a.jpg','image'=>'202207/11/70236499-8a87-3fca-92b7-2864846df78b.jpg','fax'=>'12','postcode'=>'710000','icp'=>'23','store_id'=>'0','bloc_id'=>'0','createtime'=>NULL,'updatetime'=>NULL]);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_contact}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

