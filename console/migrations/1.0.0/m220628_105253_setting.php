<?php

use yii\db\Migration;

class m220628_105253_setting extends Migration
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
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%setting}}',['id'=>'1','cate_name'=>NULL,'type'=>'string','section'=>'Wechat','key'=>'app_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'wxfb7bf418c2a81515','status'=>'1','description'=>NULL,'created_at'=>'1605602761','updated_at'=>'1605602761']);
        $this->insert('{{%setting}}',['id'=>'2','cate_name'=>NULL,'type'=>'string','section'=>'Wechat','key'=>'secret','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'8da6a965258d4ea1a08e139adc916d02','status'=>'1','description'=>NULL,'created_at'=>'1605602761','updated_at'=>'1605602761']);
        $this->insert('{{%setting}}',['id'=>'3','cate_name'=>NULL,'type'=>'string','section'=>'Wechat','key'=>'token','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'e694275623e62e3f3d0948f8cd1cc2d1','status'=>'1','description'=>NULL,'created_at'=>'1605602761','updated_at'=>'1605605618']);
        $this->insert('{{%setting}}',['id'=>'4','cate_name'=>NULL,'type'=>'string','section'=>'Wechat','key'=>'aes_key','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'Ry9whRljgf68E5bjxVCfwX3EByuCzh0w88MiORw3nnz','status'=>'1','description'=>NULL,'created_at'=>'1605602761','updated_at'=>'1605605056']);
        $this->insert('{{%setting}}',['id'=>'5','cate_name'=>NULL,'type'=>'string','section'=>'Wechat','key'=>'headimg','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'202011/17/692847cb-da31-311a-8f6c-64d4744be142.jpg','status'=>'1','description'=>NULL,'created_at'=>'1605602761','updated_at'=>'1605602761']);
        $this->insert('{{%setting}}',['id'=>'6','cate_name'=>NULL,'type'=>'string','section'=>'Wechatpay','key'=>'mch_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1604197062','status'=>'1','description'=>NULL,'created_at'=>'1605602798','updated_at'=>'1605602798']);
        $this->insert('{{%setting}}',['id'=>'7','cate_name'=>NULL,'type'=>'string','section'=>'Wechatpay','key'=>'key','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'3fa7W3nGp7KllG7rl7L5F6bRaJRDRt27','status'=>'1','description'=>NULL,'created_at'=>'1605602798','updated_at'=>'1605602798']);
        $this->insert('{{%setting}}',['id'=>'8','cate_name'=>NULL,'type'=>'string','section'=>'Wechatpay','key'=>'app_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'wxfb7bf418c2a81515','status'=>'1','description'=>NULL,'created_at'=>'1605602808','updated_at'=>'1605602808']);
        $this->insert('{{%setting}}',['id'=>'9','cate_name'=>NULL,'type'=>'string','section'=>'Map','key'=>'baiduApk','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'sY7GGnljSvLzM44mEwVtGozS','status'=>'1','description'=>NULL,'created_at'=>'1605602979','updated_at'=>'1605602979']);
        $this->insert('{{%setting}}',['id'=>'10','cate_name'=>NULL,'type'=>'string','section'=>'Map','key'=>'amapApk','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'5d9113062999b9931fcf992c085a3b2a','status'=>'1','description'=>NULL,'created_at'=>'1605602979','updated_at'=>'1608147228']);
        $this->insert('{{%setting}}',['id'=>'11','cate_name'=>NULL,'type'=>'string','section'=>'Map','key'=>'tencentApk','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1605602979','updated_at'=>'1605602979']);
        $this->insert('{{%setting}}',['id'=>'12','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'urls','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'dulaituan.hopesfire.com,dulaituanh5.hopesfire.com,localhost:81,localhost,www.ai.com,hskj.hopesfire.com','status'=>'1','description'=>NULL,'created_at'=>'1605630454','updated_at'=>'1632475081']);
        $this->insert('{{%setting}}',['id'=>'13','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'themcolor','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'skin-blue','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1606656776']);
        $this->insert('{{%setting}}',['id'=>'14','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'bloc_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1631462347']);
        $this->insert('{{%setting}}',['id'=>'15','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'store_id','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'38','status'=>'1','description'=>NULL,'created_at'=>'1606656776','updated_at'=>'1631462347']);
        $this->insert('{{%setting}}',['id'=>'16','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'flogo','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'202202/14/3fc0d173-a7f6-3da5-a8a1-783013c29410.png','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1644815492']);
        $this->insert('{{%setting}}',['id'=>'17','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'blogo','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'202202/14/085bfd8b-073e-389a-a833-3b2f1edc8039.png','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1644815492']);
        $this->insert('{{%setting}}',['id'=>'18','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'name','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'开发测试系统1','status'=>'1','description'=>NULL,'created_at'=>'1614358572','updated_at'=>'1644917203']);
        $this->insert('{{%setting}}',['id'=>'19','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'host','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'smtp.mxhichina.com','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'20','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'port','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'25','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'21','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'username','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'ai@tuhuokeji.com','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'22','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'password','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'!Wang1108','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'23','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'title','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'店滴ai','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'24','cate_name'=>NULL,'type'=>'string','section'=>'Email','key'=>'encryption','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'tls','status'=>'1','description'=>NULL,'created_at'=>'1615046762','updated_at'=>'1615046762']);
        $this->insert('{{%setting}}',['id'=>'25','cate_name'=>NULL,'type'=>'string','section'=>'Systask','key'=>'BASE_PHP_PATH','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'/www/server/php/73/bin/php','status'=>'1','description'=>NULL,'created_at'=>'1616013219','updated_at'=>'1616013219']);
        $this->insert('{{%setting}}',['id'=>'26','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'menu_type','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1618057135','updated_at'=>'1620466444']);
        $this->insert('{{%setting}}',['id'=>'27','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'backendurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'28','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'frendurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'2','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'29','cate_name'=>NULL,'type'=>'string','section'=>'Weburl','key'=>'apiurl','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'3','status'=>'1','description'=>NULL,'created_at'=>'1640079886','updated_at'=>'1640079886']);
        $this->insert('{{%setting}}',['id'=>'30','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'site_status','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1644815492','updated_at'=>'1644918048']);
        $this->insert('{{%setting}}',['id'=>'32','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'is_send_code','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1644894838','updated_at'=>'1644894838']);
        $this->insert('{{%setting}}',['id'=>'33','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'footerright','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'1','status'=>'1','description'=>NULL,'created_at'=>'1644917220','updated_at'=>'1644917220']);
        $this->insert('{{%setting}}',['id'=>'34','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'footerleft','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'2','status'=>'1','description'=>NULL,'created_at'=>'1644917220','updated_at'=>'1644917220']);
        $this->insert('{{%setting}}',['id'=>'35','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'icp','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'3','status'=>'1','description'=>NULL,'created_at'=>'1644917220','updated_at'=>'1644917220']);
        $this->insert('{{%setting}}',['id'=>'36','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'develop_status','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'0','status'=>'1','description'=>NULL,'created_at'=>'1644918048','updated_at'=>'1644918048']);
        $this->insert('{{%setting}}',['id'=>'37','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'reason','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'不关闭','status'=>'1','description'=>NULL,'created_at'=>'1644918198','updated_at'=>'1644918198']);
        $this->insert('{{%setting}}',['id'=>'38','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'intro','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'站点描述','status'=>'1','description'=>NULL,'created_at'=>'1644918228','updated_at'=>'1644918228']);
        $this->insert('{{%setting}}',['id'=>'39','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'keywords','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'32','status'=>'1','description'=>NULL,'created_at'=>'1644918228','updated_at'=>'1644918228']);
        $this->insert('{{%setting}}',['id'=>'40','cate_name'=>NULL,'type'=>'string','section'=>'Website','key'=>'description','store_id'=>NULL,'bloc_id'=>NULL,'value'=>'23','status'=>'1','description'=>NULL,'created_at'=>'1644918228','updated_at'=>'1644918228']);
        
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

