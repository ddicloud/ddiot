<?php

use yii\db\Migration;

class m221105_121058_store_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%store_category}}', [
            'category_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id'",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称'",
            'parent_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id'",
            'thumb' => "varchar(250) NOT NULL COMMENT '分类图片'",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类排序'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`category_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类管理'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%store_category}}',['category_id'=>'4','bloc_id'=>NULL,'name'=>'餐饮','parent_id'=>'3','thumb'=>'202011/19/1b54cd40-b223-36c4-9c08-a99d290035c3.jpg','sort'=>'1','create_time'=>'1605723236','update_time'=>'1605723247']);
        $this->insert('{{%store_category}}',['category_id'=>'5','bloc_id'=>NULL,'name'=>'生活服务1','parent_id'=>'0','thumb'=>'202011/20/0eb7ae5e-4094-3381-8601-9843b6de292e.jpg','sort'=>'2','create_time'=>'1605855539','update_time'=>'1620894116']);
        $this->insert('{{%store_category}}',['category_id'=>'6','bloc_id'=>NULL,'name'=>'家用电器','parent_id'=>'5','thumb'=>'202011/20/8e57777e-8572-3a98-82ea-8a064f05e079.jpg','sort'=>'6','create_time'=>'1605855626','update_time'=>'1605855626']);
        $this->insert('{{%store_category}}',['category_id'=>'7','bloc_id'=>NULL,'name'=>'精选酒类','parent_id'=>'5','thumb'=>'202011/20/97c406d0-e688-33e1-82f4-e2363f685c5d.jpg','sort'=>'7','create_time'=>'1605858568','update_time'=>'1605858568']);
        $this->insert('{{%store_category}}',['category_id'=>'8','bloc_id'=>NULL,'name'=>'餐饮行业','parent_id'=>'5','thumb'=>'202011/21/9cf43e51-ac12-3f20-a38d-7fa95e37475c.jpg','sort'=>'8','create_time'=>'1605935004','update_time'=>'1605935004']);
        $this->insert('{{%store_category}}',['category_id'=>'9','bloc_id'=>NULL,'name'=>'酒店住宿','parent_id'=>'5','thumb'=>'202011/21/c961c21b-b4da-33a5-887b-558c3a8a8ae4.jpg','sort'=>'9','create_time'=>'1605935109','update_time'=>'1605935290']);
        $this->insert('{{%store_category}}',['category_id'=>'10','bloc_id'=>NULL,'name'=>'休闲娱乐','parent_id'=>'5','thumb'=>'202011/21/61f46ace-04b5-369f-a8ca-6bdd54620d68.jpg','sort'=>'10','create_time'=>'1605935274','update_time'=>'1605935274']);
        $this->insert('{{%store_category}}',['category_id'=>'11','bloc_id'=>NULL,'name'=>'美容美发','parent_id'=>'5','thumb'=>'202011/21/750a6ee6-62d2-3450-99a8-102ec8cf66e7.jpg','sort'=>'11','create_time'=>'1605935496','update_time'=>'1605935496']);
        $this->insert('{{%store_category}}',['category_id'=>'12','bloc_id'=>NULL,'name'=>'健康养生','parent_id'=>'5','thumb'=>'202011/21/1aa48c4e-d6f4-3cee-8477-c52f9c4b1cce.jpg','sort'=>'12','create_time'=>'1605935989','update_time'=>'1605935989']);
        $this->insert('{{%store_category}}',['category_id'=>'13','bloc_id'=>NULL,'name'=>'文化旅游','parent_id'=>'5','thumb'=>'202011/21/73c1d281-b679-3269-bcd4-663292113077.jpg','sort'=>'13','create_time'=>'1605936289','update_time'=>'1605936289']);
        $this->insert('{{%store_category}}',['category_id'=>'14','bloc_id'=>NULL,'name'=>'服装服饰','parent_id'=>'5','thumb'=>'202011/21/1368f4b9-0ac5-3aeb-a6d9-fafe09c1ca5a.jpg','sort'=>'14','create_time'=>'1605936403','update_time'=>'1605936403']);
        $this->insert('{{%store_category}}',['category_id'=>'15','bloc_id'=>NULL,'name'=>'鲜果蔬菜','parent_id'=>'5','thumb'=>'202011/21/fbd13a37-7c98-36a2-834e-4354ef6a174a.jpg','sort'=>'15','create_time'=>'1605936951','update_time'=>'1605936951']);
        $this->insert('{{%store_category}}',['category_id'=>'16','bloc_id'=>NULL,'name'=>'家居百货','parent_id'=>'5','thumb'=>'202011/21/4c28bb53-f9a1-3381-ac7b-ac6f46f8bdca.jpg','sort'=>'16','create_time'=>'1605937193','update_time'=>'1605937193']);
        $this->insert('{{%store_category}}',['category_id'=>'17','bloc_id'=>NULL,'name'=>'精选箱包','parent_id'=>'5','thumb'=>'202011/21/38728c20-269b-3da8-aa71-11207bfd8d7e.jpg','sort'=>'17','create_time'=>'1605937491','update_time'=>'1605937491']);
        $this->insert('{{%store_category}}',['category_id'=>'25','bloc_id'=>NULL,'name'=>'医院','parent_id'=>'18','thumb'=>'202011/21/6263cbe1-4286-3107-8c0c-e43a99d5b5c8.jpg','sort'=>'4','create_time'=>'1605937884','update_time'=>'1605937884']);
        $this->insert('{{%store_category}}',['category_id'=>'26','bloc_id'=>NULL,'name'=>'养老院','parent_id'=>'18','thumb'=>'202011/21/d4bb2788-34b3-31b0-8988-839b440b9f92.jpg','sort'=>'5','create_time'=>'1605937992','update_time'=>'1605937992']);
        $this->insert('{{%store_category}}',['category_id'=>'27','bloc_id'=>NULL,'name'=>'康养中心','parent_id'=>'18','thumb'=>'202011/21/c72a32fc-5474-32af-8126-b640eacd0450.jpg','sort'=>'16','create_time'=>'1605938088','update_time'=>'1605938088']);
        $this->insert('{{%store_category}}',['category_id'=>'28','bloc_id'=>NULL,'name'=>'体检中心','parent_id'=>'18','thumb'=>'202011/21/ace635cb-9103-340f-93e5-ee92ede19c19.jpg','sort'=>'17','create_time'=>'1605938794','update_time'=>'1605938794']);
        $this->insert('{{%store_category}}',['category_id'=>'29','bloc_id'=>NULL,'name'=>'家政服务','parent_id'=>'18','thumb'=>'202011/21/b04be798-3fce-359f-90cf-5de29dbebddc.jpg','sort'=>'18','create_time'=>'1605938946','update_time'=>'1605938946']);
        $this->insert('{{%store_category}}',['category_id'=>'30','bloc_id'=>NULL,'name'=>'护理护工','parent_id'=>'18','thumb'=>'202011/21/dd4ae81f-4f3f-31e0-b580-e2a00bbcf81d.jpg','sort'=>'19','create_time'=>'1605939045','update_time'=>'1605939045']);
        $this->insert('{{%store_category}}',['category_id'=>'31','bloc_id'=>NULL,'name'=>'理疗保健','parent_id'=>'18','thumb'=>'202011/21/c8a1cded-5f0c-3021-9825-931ed7032a4d.jpg','sort'=>'20','create_time'=>'1605939295','update_time'=>'1605939295']);
        $this->insert('{{%store_category}}',['category_id'=>'32','bloc_id'=>NULL,'name'=>'智慧社区','parent_id'=>'0','thumb'=>'202011/21/03f48696-c2a0-3dce-8d00-289bfe026736.jpg','sort'=>'4','create_time'=>'1605939439','update_time'=>'1605939439']);
        $this->insert('{{%store_category}}',['category_id'=>'35','bloc_id'=>NULL,'name'=>'消费养老','parent_id'=>'0','thumb'=>'202011/21/7b3b3e1a-0221-351c-8500-011ce4b7a57d.jpg','sort'=>'3','create_time'=>'1605939685','update_time'=>'1605939685']);
        $this->insert('{{%store_category}}',['category_id'=>'36','bloc_id'=>NULL,'name'=>'医院','parent_id'=>'35','thumb'=>'202011/26/ef1e0a64-e3a8-301f-bd95-b5b7b92d1a5d.jpg','sort'=>'1','create_time'=>'1606390436','update_time'=>'1606390436']);
        $this->insert('{{%store_category}}',['category_id'=>'37','bloc_id'=>NULL,'name'=>'养老院','parent_id'=>'35','thumb'=>'202011/26/8bf089a4-067f-3fb4-9a59-9c1d36b34fc8.jpg','sort'=>'2','create_time'=>'1606390460','update_time'=>'1606390460']);
        $this->insert('{{%store_category}}',['category_id'=>'38','bloc_id'=>NULL,'name'=>'康养中心','parent_id'=>'35','thumb'=>'202011/26/01f8a819-9b8c-38f4-9edf-dfa627d1e579.jpg','sort'=>'3','create_time'=>'1606390500','update_time'=>'1606390500']);
        $this->insert('{{%store_category}}',['category_id'=>'39','bloc_id'=>NULL,'name'=>'体检中心','parent_id'=>'35','thumb'=>'202011/26/6797d7b6-2c1c-384c-ad78-c374b173dcdc.jpg','sort'=>'4','create_time'=>'1606390525','update_time'=>'1606390525']);
        $this->insert('{{%store_category}}',['category_id'=>'40','bloc_id'=>NULL,'name'=>'家政服务','parent_id'=>'35','thumb'=>'202011/26/1b1a6fce-fecd-3812-adda-34e4917a4bc8.jpg','sort'=>'5','create_time'=>'1606390587','update_time'=>'1606390587']);
        $this->insert('{{%store_category}}',['category_id'=>'41','bloc_id'=>NULL,'name'=>'护理护工','parent_id'=>'35','thumb'=>'202011/26/ababeb2f-5bc6-37a1-a476-b30e04fc0bb3.jpg','sort'=>'6','create_time'=>'1606390607','update_time'=>'1606390607']);
        $this->insert('{{%store_category}}',['category_id'=>'42','bloc_id'=>NULL,'name'=>'理疗保健','parent_id'=>'35','thumb'=>'202011/26/d44e14b2-c6fa-37ab-939c-3a9e92f37753.jpg','sort'=>'8','create_time'=>'1606390642','update_time'=>'1606390642']);
        $this->insert('{{%store_category}}',['category_id'=>'43','bloc_id'=>NULL,'name'=>'社区团购','parent_id'=>'32','thumb'=>'202011/26/bb33a6b2-8fc6-37b5-9766-a5a0b6474f4f.jpg','sort'=>'1','create_time'=>'1606390819','update_time'=>'1606390819']);
        $this->insert('{{%store_category}}',['category_id'=>'45','bloc_id'=>NULL,'name'=>'社区门店','parent_id'=>'32','thumb'=>'202011/26/dec9265e-d1f5-3acf-9a97-cb380f2bfcb4.jpg','sort'=>'3','create_time'=>'1606391021','update_time'=>'1606391021']);
        $this->insert('{{%store_category}}',['category_id'=>'46','bloc_id'=>NULL,'name'=>'配送服务','parent_id'=>'32','thumb'=>'202011/26/8bd0af69-22f6-358e-bcc9-eeb621c706cb.jpg','sort'=>'7','create_time'=>'1606391234','update_time'=>'1606391234']);
        $this->insert('{{%store_category}}',['category_id'=>'47','bloc_id'=>NULL,'name'=>'公益服务','parent_id'=>'0','thumb'=>'202011/26/149a8f68-3a88-3e05-87b2-fc21db890315.jpg','sort'=>'15','create_time'=>'1606391606','update_time'=>'1606391606']);
        $this->insert('{{%store_category}}',['category_id'=>'48','bloc_id'=>NULL,'name'=>'扶贫','parent_id'=>'47','thumb'=>'202011/26/b7754c8a-87f8-3aee-ad66-fb3b0061041c.jpg','sort'=>'16','create_time'=>'1606391788','update_time'=>'1606391788']);
        $this->insert('{{%store_category}}',['category_id'=>'49','bloc_id'=>NULL,'name'=>'助农','parent_id'=>'47','thumb'=>'202011/26/614fbffd-ae09-3bf9-88eb-9d21f8f12ad0.jpg','sort'=>'17','create_time'=>'1606391870','update_time'=>'1606391870']);
        $this->insert('{{%store_category}}',['category_id'=>'50','bloc_id'=>NULL,'name'=>'助残','parent_id'=>'47','thumb'=>'202011/26/3a16a285-f44b-3308-9583-71f925186d3b.jpg','sort'=>'18','create_time'=>'1606392125','update_time'=>'1606392125']);
        $this->insert('{{%store_category}}',['category_id'=>'51','bloc_id'=>NULL,'name'=>'生活服务项目','parent_id'=>'5','thumb'=>'http://www.ai.com/attachment/202106/10/fb832587-de57-35f4-9dc1-0a72664655cc.jpg','sort'=>'0','create_time'=>'1623307362','update_time'=>'1623307362']);
        $this->insert('{{%store_category}}',['category_id'=>'52','bloc_id'=>NULL,'name'=>'345','parent_id'=>'35','thumb'=>'http://www.ai.com/attachment/202106/10/798fb595-4d12-3ca4-8492-c4898cf0d38f.jpg','sort'=>'0','create_time'=>'1623307601','update_time'=>'1623307601']);
        $this->insert('{{%store_category}}',['category_id'=>'53','bloc_id'=>'13','name'=>'1','parent_id'=>'5','thumb'=>'202207/14/d0c61156-f3b1-32c6-9b4e-804bd5e42aa7.jpg','sort'=>'0','create_time'=>'1657767984','update_time'=>'1657767984']);
        $this->insert('{{%store_category}}',['category_id'=>'54','bloc_id'=>'13','name'=>'分类1','parent_id'=>'0','thumb'=>'202207/14/59f75198-f319-3748-9b60-81fae77e3230.jpg','sort'=>'0','create_time'=>'1657788470','update_time'=>'1657788470']);
        $this->insert('{{%store_category}}',['category_id'=>'55','bloc_id'=>'13','name'=>'分类2','parent_id'=>'5','thumb'=>'202207/14/2f814dc0-3475-3ca2-ab35-2e5d0d90de60.jpg','sort'=>'0','create_time'=>'1657788485','update_time'=>'1657788485']);
        $this->insert('{{%store_category}}',['category_id'=>'56','bloc_id'=>'13','name'=>'子类1','parent_id'=>'54','thumb'=>'202207/14/847d24d7-74d8-3a6c-80fb-de69d5778f4f.jpg','sort'=>'0','create_time'=>'1657788676','update_time'=>'1657788676']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%store_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

