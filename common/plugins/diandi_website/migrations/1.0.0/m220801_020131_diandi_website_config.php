<?php

use yii\db\Migration;

class m220801_020131_diandi_website_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_config}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'name' => "varchar(20) NOT NULL DEFAULT '' COMMENT '字段名英文'",
            'label' => "varchar(50) NOT NULL COMMENT '字段标注'",
            'value' => "varchar(3000) NOT NULL DEFAULT '' COMMENT '字段值'",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'language' => "varchar(20) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('u-language_name','{{%diandi_website_config}}','language, name',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_config}}',['id'=>'2','name'=>'contact_us','label'=>'联系我们','value'=>'<p>公司: 在北京网络科技</p><p>联系人: 李sss</p><p>QQ: 739800600</p><p>电话: 1304351</p><p>E-mail: 739800600@qq.com</p><p>地址: 北京市丰台区大红门</p>','created_at'=>'1481350005','updated_at'=>'1482902162','language'=>'zh-CN']);
        $this->insert('{{%diandi_website_config}}',['id'=>'3','name'=>'contact_us_page_id','label'=>'联系我们','value'=>'1','created_at'=>'1481355647','updated_at'=>'1483169811','language'=>'zh-CN']);
        $this->insert('{{%diandi_website_config}}',['id'=>'4','name'=>'jianjie','label'=>'企业简介','value'=>'北京雄鹰国际旅行社是新时代投资管理集团旗下的专业旅游平台,依托集团广泛而强大的资源和团队，雄鹰国旅专注于游学交流，商务考察，专项旅行，帆船体验，机票代理等，致力于通过旅行提高青少年的品格与素养，为旅行者提供专业化，个性化的优质服务testtesttest','created_at'=>'1490458199','updated_at'=>'1490458199','language'=>'zh-CN']);
        $this->insert('{{%diandi_website_config}}',['id'=>'5','name'=>'gongyi','label'=>'公益广告','value'=>'<script type=\"text/javascript\"> var yibo_id =40276;</script><script src=\"Http://yibo.iyiyun.com/yibo.js?random=309727\" type=\"text/javascript\"></script>','created_at'=>'1494309812','updated_at'=>'1494309845','language'=>'zh-CN']);
        $this->insert('{{%diandi_website_config}}',['id'=>'6','name'=>'top_right_data','label'=>'头部右侧数据','value'=>'电话:13240702278,17346512591','created_at'=>'1507598988','updated_at'=>'1507598988','language'=>'zh-CN']);
        $this->insert('{{%diandi_website_config}}',['id'=>'10','name'=>'contact_us','label'=>'contact us','value'=>'dsfsfdsfsdfds','created_at'=>'1585993034','updated_at'=>'1585993034','language'=>'en-US']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

