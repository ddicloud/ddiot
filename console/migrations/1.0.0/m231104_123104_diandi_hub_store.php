<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_store extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_store}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'member_id' => "int(11) NULL",
            'name' => "varchar(30) NULL COMMENT '商家名称'",
            'mobile' => "varchar(30) NOT NULL COMMENT '商家手机号'",
            'address' => "varchar(100) NULL COMMENT '商家地址'",
            'city' => "int(11) NULL COMMENT '城市'",
            'provice' => "int(11) NULL COMMENT '省份'",
            'area' => "int(11) NULL COMMENT '区域'",
            'desc' => "varchar(255) NULL COMMENT '店铺介绍'",
            'linkman' => "varchar(30) NULL COMMENT '联系人'",
            'storefront' => "varchar(255) NULL COMMENT '店面门头'",
            'business' => "varchar(255) NULL COMMENT '营业执照'",
            'cardFront' => "varchar(255) NULL COMMENT '身份证正面'",
            'cardReverse' => "varchar(255) NULL COMMENT '身份证反面'",
            'interior' => "varchar(255) NULL COMMENT '店铺内景'",
            'wechat_code' => "varchar(255) NULL COMMENT '微信二维码'",
            'certification' => "varchar(255) NULL COMMENT '其他资质'",
            'status' => "int(11) NULL COMMENT '店铺审核状态'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_store}}',['id'=>'1','member_id'=>'12','name'=>'12','mobile'=>'1223412454','address'=>'','city'=>NULL,'provice'=>NULL,'area'=>NULL,'desc'=>'12','linkman'=>'12','storefront'=>'202202/24/97f8854f-28ce-3877-bf1f-7485bb19c593.jpg','business'=>'','cardFront'=>'','cardReverse'=>'202202/24/65a98b57-994b-3290-b496-bd82d83f5e1e.jpg','interior'=>'','wechat_code'=>'','certification'=>'202202/24/57e9e612-7c1b-3d44-9cbc-cb8d5cf433d7.jpg','status'=>'0','create_time'=>'1645675373','update_time'=>'1645675448']);
        $this->insert('{{%diandi_hub_store}}',['id'=>'2','member_id'=>'58','name'=>'1212','mobile'=>'11112121212','address'=>'12','city'=>'3108','provice'=>'3022','area'=>'3022','desc'=>'12212','linkman'=>'12','storefront'=>'202204/12/c327c1e8-ff3b-3fc0-a42b-7bd27d11c446.jpeg','business'=>'202204/12/a70e58af-6fee-320d-adc2-838689276a5f.jpeg','cardFront'=>'202204/12/f68f86d2-5bcc-33cc-84e6-8d95280a009e.jpeg','cardReverse'=>'202204/12/569ccfe9-0883-3e00-9714-74c05dd5f5fc.jpeg','interior'=>'202204/12/89e71a1b-00ab-317b-9ef8-6897e8ae4b6f.jpeg','wechat_code'=>'202204/12/38dc3138-e418-33e4-84ca-3b27b9b25eb9.jpeg','certification'=>'202204/12/be428de3-0430-3a02-9a80-056458c3c285.jpeg','status'=>'1','create_time'=>'1649753193','update_time'=>'1653498362']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_store}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

