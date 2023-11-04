<?php

use yii\db\Migration;

class m231104_123103_bea_cloud_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%bea_cloud_category}}', [
            'category_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称'",
            'parent_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'image_id' => "varchar(250) NOT NULL",
            'sort' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'goods_id' => "int(11) NULL",
            'wxapp_id' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'update_time' => "int(11) unsigned NOT NULL DEFAULT '0'",
            'PRIMARY KEY (`category_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分类管理'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'1','store_id'=>'139','bloc_id'=>'38','name'=>'智能门锁','parent_id'=>'0','image_id'=>'202207/19/a6fb5fcf-8099-3aa1-8b11-5bc9bf8e42e1.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1657692493','update_time'=>'1658222670']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'2','store_id'=>'139','bloc_id'=>'38','name'=>'智能门锁','parent_id'=>'1','image_id'=>'202207/14/45322014-e7dd-390b-b163-f3dbb1946973.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1657692505','update_time'=>'1657793964']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'3','store_id'=>'139','bloc_id'=>'38','name'=>'分类二二','parent_id'=>'0','image_id'=>'202207/19/de9e9e1c-642b-38f6-a0f6-2d025d9ce303.jpg','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658222565','update_time'=>'1658222565']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'4','store_id'=>'139','bloc_id'=>'38','name'=>'智能开关','parent_id'=>'1','image_id'=>'202207/19/0d3f7a7d-8b02-352d-808a-7bae310eaefd.png','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658224441','update_time'=>'1658224441']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'5','store_id'=>'139','bloc_id'=>'38','name'=>'智能开关','parent_id'=>'1','image_id'=>'202207/19/0be49f23-c19c-3234-a172-f15d58879bb7.png','sort'=>'3','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1658224484','update_time'=>'1658224484']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'6','store_id'=>'138','bloc_id'=>'38','name'=>'服务','parent_id'=>'0','image_id'=>'202210/09/85933f3d-be44-327c-8621-e28e1c54d179.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1665281170','update_time'=>'1665281170']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'7','store_id'=>'138','bloc_id'=>'38','name'=>'服务二级','parent_id'=>'6','image_id'=>'202210/09/a62f0231-bbc1-378f-8179-8375aebaef17.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1665281356','update_time'=>'1665281356']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'8','store_id'=>'138','bloc_id'=>'38','name'=>'分类1','parent_id'=>'0','image_id'=>'202303/03/ee72e238-7540-3623-b06f-fdafe7e5b849.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1677837564','update_time'=>'1677837564']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'9','store_id'=>'138','bloc_id'=>'38','name'=>'分类2','parent_id'=>'8','image_id'=>'202303/03/1560a260-d0cc-30a0-b432-b4fd0f985e5b.png','sort'=>'23','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1677837581','update_time'=>'1677837581']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'10','store_id'=>'138','bloc_id'=>'38','name'=>'美白肌肤','parent_id'=>'0','image_id'=>'202303/04/5deabccb-2c2f-31ed-aae6-dbdaa842248b.jpg','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1677924029','update_time'=>'1677924029']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'11','store_id'=>'138','bloc_id'=>'38','name'=>'修复下巴','parent_id'=>'0','image_id'=>'202303/04/d0492040-453a-31d1-89fc-55b6ead9caa6.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1677924116','update_time'=>'1677924116']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'12','store_id'=>'138','bloc_id'=>'38','name'=>'分类1','parent_id'=>'10','image_id'=>'202303/04/a2a45182-1da8-3802-ae27-e614dc110a3b.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1677924193','update_time'=>'1677924193']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'13','store_id'=>'149','bloc_id'=>'51','name'=>'美白护肤','parent_id'=>'0','image_id'=>'202303/14/9afca70e-6551-36a5-9346-03cd4479b604.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678762676','update_time'=>'1678762676']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'14','store_id'=>'149','bloc_id'=>'51','name'=>'修复面部','parent_id'=>'0','image_id'=>'202303/14/3ad74ee0-c9f3-3fcd-acbc-3d50166dc813.jpg','sort'=>'12','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678762823','update_time'=>'1678797711']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'15','store_id'=>'149','bloc_id'=>'51','name'=>'胶原蛋白','parent_id'=>'0','image_id'=>'202303/14/2c9ed840-a4ae-38d8-83b4-e622fc3d9ef9.png','sort'=>'2','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678762906','update_time'=>'1678762906']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'16','store_id'=>'149','bloc_id'=>'51','name'=>'修复1','parent_id'=>'13','image_id'=>'202303/14/1b2779ea-caa2-3848-9fd6-151ee9e4575e.png','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678762972','update_time'=>'1678762972']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'17','store_id'=>'149','bloc_id'=>'51','name'=>'修复2','parent_id'=>'13','image_id'=>'202303/14/e0f4aba1-f4e9-3fe7-8fb0-06f2efa0e27e.png','sort'=>'1','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678763007','update_time'=>'1678763007']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'19','store_id'=>'149','bloc_id'=>'51','name'=>'二级分类','parent_id'=>'14','image_id'=>'202303/14/36321ca0-1c8b-37fc-8805-c68a9da760e4.jpg','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1678798202','update_time'=>'1678798202']);
        $this->insert('{{%bea_cloud_category}}',['category_id'=>'20','store_id'=>'149','bloc_id'=>'51','name'=>'山泉水','parent_id'=>'0','image_id'=>'202303/20/c1ef7966-066f-35dd-86d6-c9764a0141fe.jpg','sort'=>'0','goods_id'=>'0','wxapp_id'=>'0','create_time'=>'1679280999','update_time'=>'1679280999']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%bea_cloud_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

