<?php

use yii\db\Migration;

class m220801_020131_diandi_website_solution extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_solution}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'bloc_id' => "int(11) NOT NULL",
            'store_id' => "int(11) NOT NULL",
            'cate_id' => "int(11) NOT NULL COMMENT '分类ID'",
            'name' => "varchar(45) NOT NULL COMMENT '名称'",
            'icon' => "varchar(180) NOT NULL COMMENT 'ICON'",
            'des' => "varchar(450) NOT NULL COMMENT '描述'",
            'created_at' => "datetime NOT NULL COMMENT '创建时间'",
            'updated_at' => "datetime NOT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='解决方案'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_solution}}',['id'=>'1','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'农业认养','icon'=>'202207/06/5895245e-3edd-37f4-98c8-b1a3c5b5937c.png','des'=>'针对农业养殖，采用互联网认养方式进行认养，用户深度参与到农业活动','created_at'=>'2022-07-06 09:15:07','updated_at'=>'2022-07-08 13:09:00']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'2','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'连锁店铺','icon'=>'202207/07/f97484eb-b357-3689-852e-40ec8a48ac9b.jpg','des'=>'直营店铺，连锁店铺，多店铺库存维护与订单管理系统','created_at'=>'2022-07-07 17:14:41','updated_at'=>'2022-07-08 13:09:24']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'3','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'在线点单','icon'=>'202207/07/ca5e9ddf-ee29-3dac-a248-b356528938a3.jpg','des'=>'外卖点单，单商户堂食点单系统','created_at'=>'2022-07-07 17:15:03','updated_at'=>'2022-07-08 13:09:45']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'4','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'花卉市场','icon'=>'202207/07/b0cbb3b1-01aa-3fe0-8a9d-6a83814a3b4b.jpg','des'=>'专业针对花卉交易市场，交易集散地开发的仓位，订单，库存管理一体化系统','created_at'=>'2022-07-07 17:15:24','updated_at'=>'2022-07-08 13:10:21']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'5','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'智慧茶室','icon'=>'202207/07/52dc36a1-f71b-36cf-bb02-d540d5160596.jpg','des'=>'慢生活理念，无人值守茶室，打造用户私密商务洽谈，休闲交友体验中心','created_at'=>'2022-07-07 17:16:32','updated_at'=>'2022-07-08 13:11:23']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'6','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'麻将房','icon'=>'202207/07/a79574be-c7e1-35f9-bc59-b212b92d5f1d.jpg','des'=>'可针对麻将房进行房间电源管控，房间用时收费，门锁控制','created_at'=>'2022-07-07 17:16:50','updated_at'=>'2022-07-08 13:11:54']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'7','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'公寓','icon'=>'202207/07/e212652a-b3a9-3d17-96fa-be3616a83334.jpg','des'=>'公寓访客，房间管控，门锁，电源，灯具智能控制','created_at'=>'2022-07-07 17:17:03','updated_at'=>'2022-07-08 13:12:28']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'8','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'智能门锁','icon'=>'202207/07/b691d093-535a-3d79-bff1-942d02c6373f.jpg','des'=>'区别与家用门锁，支持多种开锁方式，可结合商业场景进行开发','created_at'=>'2022-07-07 17:17:46','updated_at'=>'2022-07-08 13:13:00']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'9','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'智能网关','icon'=>'202207/07/20527e34-e1f4-390e-a8aa-ece040b8d91c.jpg','des'=>'针对门锁与智能灯控制的网关，可快捷接入','created_at'=>'2022-07-07 17:18:00','updated_at'=>'2022-07-08 13:13:30']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'10','bloc_id'=>'8','store_id'=>'61','cate_id'=>'2','name'=>'智能开关','icon'=>'202207/07/66b3a40a-61b9-313b-b486-78c00cdb67af.jpg','des'=>'房间灯控系统枢纽，远程开灯，定时断电，限时使用','created_at'=>'2022-07-07 17:18:13','updated_at'=>'2022-07-08 13:14:07']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'11','bloc_id'=>'8','store_id'=>'61','cate_id'=>'3','name'=>'语音控制','icon'=>'202207/07/11755d54-3ead-38f2-b34a-069be8db7716.jpg','des'=>'基于语言识别技术，进行智能家居与远程物联网控制','created_at'=>'2022-07-07 17:19:07','updated_at'=>'2022-07-08 13:14:35']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'12','bloc_id'=>'8','store_id'=>'61','cate_id'=>'3','name'=>'远程监控','icon'=>'202207/07/882c605e-e8ad-3197-a62a-c2d3316c2d87.jpg','des'=>'远程监控','created_at'=>'2022-07-07 17:19:25','updated_at'=>'2022-07-07 17:19:25']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'13','bloc_id'=>'8','store_id'=>'61','cate_id'=>'3','name'=>'疫情防控','icon'=>'202207/07/f8873b86-1065-3257-90d6-15cb20997ab6.jpg','des'=>'疫情防控2','created_at'=>'2022-07-07 17:19:41','updated_at'=>'2022-07-07 17:19:41']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'14','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'分销经营','icon'=>'202207/07/60e59c4b-1d17-3c05-9270-a0dd8b9c3c8b.jpg','des'=>'支持单商户分销，多商户分销，等级分销，团队分销、消费返利多种模式','created_at'=>'2022-07-07 17:20:20','updated_at'=>'2022-07-08 13:15:25']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'15','bloc_id'=>'8','store_id'=>'61','cate_id'=>'3','name'=>'一对一语音','icon'=>'202207/07/f88eda9b-bf5c-3ae9-99ac-fd0ccd1da453.jpg','des'=>'可以集成到小程序，app中的一对一语音通话技术','created_at'=>'2022-07-07 17:22:21','updated_at'=>'2022-07-08 13:16:05']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'16','bloc_id'=>'8','store_id'=>'61','cate_id'=>'3','name'=>'一对多语音','icon'=>'202207/07/46594b62-539c-3eb4-ac35-2d6ef08481c2.jpg','des'=>'可以集成到小程序，app中的一对多语音通话技术','created_at'=>'2022-07-07 17:22:39','updated_at'=>'2022-07-08 13:16:19']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'17','bloc_id'=>'8','store_id'=>'61','cate_id'=>'1','name'=>'积分商城','icon'=>'202207/07/a80a3e58-304e-33d1-b5ff-77c26174a817.jpg','des'=>'满足各种业务快速对接积分功能，实现积分兑换','created_at'=>'2022-07-07 17:45:39','updated_at'=>'2022-07-08 13:16:51']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'18','bloc_id'=>'8','store_id'=>'61','cate_id'=>'4','name'=>'党政资讯','icon'=>'202207/08/aaa1cde6-bd71-39e5-9759-492f93fdfd7e.jpg','des'=>'党政资讯内容，包含视频，音频，文字，图片等信息展示','created_at'=>'2022-07-08 13:06:52','updated_at'=>'2022-07-08 13:17:13']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'19','bloc_id'=>'8','store_id'=>'61','cate_id'=>'4','name'=>'在线考试','icon'=>'202207/08/82eb4cb1-247a-3574-addf-9ebced86a2c0.jpg','des'=>'可创建党员考核题库，围绕题库进行多种方式的考试与成绩核查','created_at'=>'2022-07-08 13:07:10','updated_at'=>'2022-07-08 13:17:59']);
        $this->insert('{{%diandi_website_solution}}',['id'=>'20','bloc_id'=>'8','store_id'=>'61','cate_id'=>'4','name'=>'党员管理','icon'=>'202207/08/28b1878a-4c9c-37e9-84a4-1b40d8a21199.jpg','des'=>'党员风采展示，党员信息公式','created_at'=>'2022-07-08 13:07:24','updated_at'=>'2022-07-08 13:18:17']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_solution}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

