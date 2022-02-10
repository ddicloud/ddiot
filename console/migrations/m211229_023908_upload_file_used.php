<?php

use yii\db\Migration;

class m211229_023908_upload_file_used extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%upload_file_used}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户id'",
            'file_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'store_id' => "int(11) NULL DEFAULT '0' COMMENT '商户id'",
            'from_type' => "varchar(255) NULL",
            'from_id' => "int(11) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('file_id','{{%upload_file_used}}','file_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%upload_file_used}}',['id'=>'2','user_id'=>'1','file_id'=>'9','bloc_id'=>'8','store_id'=>'59','from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327383','update_time'=>NULL]);
        $this->insert('{{%upload_file_used}}',['id'=>'3','user_id'=>'0','file_id'=>'13','bloc_id'=>'8','store_id'=>'59','from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327570','update_time'=>NULL]);
        $this->insert('{{%upload_file_used}}',['id'=>'4','user_id'=>'0','file_id'=>'14','bloc_id'=>'8','store_id'=>'59','from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327639','update_time'=>NULL]);
        $this->insert('{{%upload_file_used}}',['id'=>'5','user_id'=>'0','file_id'=>'15','bloc_id'=>'8','store_id'=>'59','from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327707','update_time'=>NULL]);
        $this->insert('{{%upload_file_used}}',['id'=>'6','user_id'=>'11','file_id'=>'19','bloc_id'=>NULL,'store_id'=>NULL,'from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327885','update_time'=>'1639327885']);
        $this->insert('{{%upload_file_used}}',['id'=>'7','user_id'=>'11','file_id'=>'20','bloc_id'=>NULL,'store_id'=>NULL,'from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327919','update_time'=>'1639327919']);
        $this->insert('{{%upload_file_used}}',['id'=>'8','user_id'=>'11','file_id'=>'21','bloc_id'=>'0','store_id'=>'0','from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639328060','update_time'=>'1639328060']);
        $this->insert('{{%upload_file_used}}',['id'=>'9','user_id'=>'29','file_id'=>'13735','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640503386','update_time'=>'1640503386']);
        $this->insert('{{%upload_file_used}}',['id'=>'10','user_id'=>'29','file_id'=>'13736','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640516002','update_time'=>'1640516002']);
        $this->insert('{{%upload_file_used}}',['id'=>'11','user_id'=>'29','file_id'=>'13737','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640518430','update_time'=>'1640518430']);
        $this->insert('{{%upload_file_used}}',['id'=>'12','user_id'=>'29','file_id'=>'13738','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640518518','update_time'=>'1640518518']);
        $this->insert('{{%upload_file_used}}',['id'=>'13','user_id'=>'29','file_id'=>'13739','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640519001','update_time'=>'1640519001']);
        $this->insert('{{%upload_file_used}}',['id'=>'14','user_id'=>'29','file_id'=>'13740','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640521250','update_time'=>'1640521250']);
        $this->insert('{{%upload_file_used}}',['id'=>'15','user_id'=>'29','file_id'=>'13741','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640521597','update_time'=>'1640521597']);
        $this->insert('{{%upload_file_used}}',['id'=>'16','user_id'=>'29','file_id'=>'13742','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640521641','update_time'=>'1640521641']);
        $this->insert('{{%upload_file_used}}',['id'=>'17','user_id'=>'29','file_id'=>'13743','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640521657','update_time'=>'1640521657']);
        $this->insert('{{%upload_file_used}}',['id'=>'18','user_id'=>'29','file_id'=>'13744','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640522406','update_time'=>'1640522406']);
        $this->insert('{{%upload_file_used}}',['id'=>'19','user_id'=>'29','file_id'=>'13745','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640522698','update_time'=>'1640522698']);
        $this->insert('{{%upload_file_used}}',['id'=>'20','user_id'=>'29','file_id'=>'13746','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640522930','update_time'=>'1640522930']);
        $this->insert('{{%upload_file_used}}',['id'=>'21','user_id'=>'29','file_id'=>'13747','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640523145','update_time'=>'1640523145']);
        $this->insert('{{%upload_file_used}}',['id'=>'22','user_id'=>'29','file_id'=>'13748','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640523548','update_time'=>'1640523548']);
        $this->insert('{{%upload_file_used}}',['id'=>'23','user_id'=>'29','file_id'=>'13749','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640523783','update_time'=>'1640523783']);
        $this->insert('{{%upload_file_used}}',['id'=>'24','user_id'=>'29','file_id'=>'13750','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640524779','update_time'=>'1640524779']);
        $this->insert('{{%upload_file_used}}',['id'=>'25','user_id'=>'29','file_id'=>'13751','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640525189','update_time'=>'1640525189']);
        $this->insert('{{%upload_file_used}}',['id'=>'26','user_id'=>'29','file_id'=>'13752','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640525938','update_time'=>'1640525938']);
        $this->insert('{{%upload_file_used}}',['id'=>'27','user_id'=>'29','file_id'=>'13753','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640526169','update_time'=>'1640526169']);
        $this->insert('{{%upload_file_used}}',['id'=>'28','user_id'=>'29','file_id'=>'13754','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640526754','update_time'=>'1640526754']);
        $this->insert('{{%upload_file_used}}',['id'=>'29','user_id'=>'29','file_id'=>'13755','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640526839','update_time'=>'1640526839']);
        $this->insert('{{%upload_file_used}}',['id'=>'30','user_id'=>'29','file_id'=>'13756','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640527111','update_time'=>'1640527111']);
        $this->insert('{{%upload_file_used}}',['id'=>'31','user_id'=>'29','file_id'=>'13757','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640527274','update_time'=>'1640527274']);
        $this->insert('{{%upload_file_used}}',['id'=>'32','user_id'=>'29','file_id'=>'13758','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640527402','update_time'=>'1640527402']);
        $this->insert('{{%upload_file_used}}',['id'=>'33','user_id'=>'29','file_id'=>'13759','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640527521','update_time'=>'1640527521']);
        $this->insert('{{%upload_file_used}}',['id'=>'34','user_id'=>'29','file_id'=>'13760','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640530471','update_time'=>'1640530471']);
        $this->insert('{{%upload_file_used}}',['id'=>'35','user_id'=>'29','file_id'=>'13761','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640530869','update_time'=>'1640530869']);
        $this->insert('{{%upload_file_used}}',['id'=>'36','user_id'=>'29','file_id'=>'13762','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640531574','update_time'=>'1640531574']);
        $this->insert('{{%upload_file_used}}',['id'=>'37','user_id'=>'29','file_id'=>'13763','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640531905','update_time'=>'1640531905']);
        $this->insert('{{%upload_file_used}}',['id'=>'38','user_id'=>'29','file_id'=>'13764','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640532114','update_time'=>'1640532114']);
        $this->insert('{{%upload_file_used}}',['id'=>'39','user_id'=>'29','file_id'=>'13765','bloc_id'=>'27','store_id'=>'75','from_type'=>'local','from_id'=>'0','create_time'=>'1640532424','update_time'=>'1640532424']);
        $this->insert('{{%upload_file_used}}',['id'=>'40','user_id'=>'29','file_id'=>'13766','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1640613722','update_time'=>'1640613722']);
        $this->insert('{{%upload_file_used}}',['id'=>'41','user_id'=>'29','file_id'=>'13767','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1640614482','update_time'=>'1640614482']);
        $this->insert('{{%upload_file_used}}',['id'=>'42','user_id'=>'29','file_id'=>'13768','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1640616280','update_time'=>'1640616280']);
        $this->insert('{{%upload_file_used}}',['id'=>'43','user_id'=>'29','file_id'=>'13769','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1640616593','update_time'=>'1640616593']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%upload_file_used}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

