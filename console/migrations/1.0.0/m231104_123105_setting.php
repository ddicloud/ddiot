<?php

use yii\db\Migration;

class m231104_123105_setting extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%setting}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'cate_name' => "varchar(255) NULL",
            'type' => "varchar(10) NOT NULL",
            'section' => "varchar(255) NOT NULL",
            'key' => "varchar(255) NOT NULL",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'value' => "text NOT NULL",
            'status' => "smallint(6) NOT NULL DEFAULT '1'",
            'description' => "varchar(255) NULL",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */

        /* 表数据 */
        $this->insert('{{%setting}}',['id'=>'13','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'themcolor','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'skin-blue','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1606656776']);
        $this->insert('{{%setting}}',['id'=>'14','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'bloc_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1631462347']);
        $this->insert('{{%setting}}',['id'=>'15','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'store_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'38','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1631462347']);
        $this->insert('{{%setting}}',['id'=>'16','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'flogo','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'202210/24/9bd8ca5a-bbfc-3bb1-bc13-bcb0e5acdab7.png','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1666595468']);
        $this->insert('{{%setting}}',['id'=>'17','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'blogo','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'202307/14/f2a56211-cf4f-33db-85f3-fc96efa7e3e3.png','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1689329648']);
        $this->insert('{{%setting}}',['id'=>'18','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'name','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'店滴云','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1642397905']);
        $this->insert('{{%setting}}',['id'=>'26','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'menu_type','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1618057135','updated_at'=>'1620466444']);
        $this->insert('{{%setting}}',['id'=>'27','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'backendurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'28','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'frendurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'2','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'29','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'apiurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'3','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'30','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'intro','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'让经营场所更智能','status'=>'1','description'=>NULL,'created_at'=>'1641659464','updated_at'=>'1659508488']);
        $this->insert('{{%setting}}',['id'=>'31','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'is_send_code','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1653963031','updated_at'=>'1678194271']);
        $this->insert('{{%setting}}',['id'=>'32','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'site_status','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1653963031','updated_at'=>'1653963031']);
        $this->insert('{{%setting}}',['id'=>'33','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'develop_status','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1653963031','updated_at'=>'1661946177']);
        $this->insert('{{%setting}}',['id'=>'34','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'keywords','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'店滴云','status'=>'1','description'=>NULL,'created_at'=>'1653963031','updated_at'=>'1653963031']);
        $this->insert('{{%setting}}',['id'=>'35','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'description','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'让经营场所更智能','status'=>'1','description'=>NULL,'created_at'=>'1653963031','updated_at'=>'1659508488']);
        $this->insert('{{%setting}}',['id'=>'36','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'footerleft','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'西安店滴云网络科技有限公司','status'=>'1','description'=>NULL,'created_at'=>'1657539470','updated_at'=>'1657539470']);
        $this->insert('{{%setting}}',['id'=>'37','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'footerright','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'Powered by 店滴云 v1.9.1 © 2013-2022','status'=>'1','description'=>NULL,'created_at'=>'1657539470','updated_at'=>'1657539470']);
        $this->insert('{{%setting}}',['id'=>'38','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'location','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'https://beian.miit.gov.cn/#/Integrated/recordQuery','status'=>'1','description'=>NULL,'created_at'=>'1657539470','updated_at'=>'1657539470']);
        $this->insert('{{%setting}}',['id'=>'39','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'icp','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'陕ICP备2022008115号-1','status'=>'1','description'=>NULL,'created_at'=>'1657539470','updated_at'=>'1657606532']);
        $this->insert('{{%setting}}',['id'=>'44','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'bloc_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'38','status'=>'1','description'=>NULL,'created_at'=>'1681218313','updated_at'=>'1681218313']);


        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%setting}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

